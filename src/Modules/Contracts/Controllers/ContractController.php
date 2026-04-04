<?php

namespace IMO\Modules\Contracts\Controllers;

use IMO\Core\Controller;
use IMO\Core\Database\Connection;
use IMO\Modules\Contracts\Services\SignatureService;
use IMO\Modules\Contracts\Services\OtpService;
use IMO\Modules\Audit\Services\AuditService;
use Exception;

/**
 * ContractController - Módulo de Firma Digital con OTP
 * empresaIMO - HIPAA Compliance + Click-to-Sign + Verificación de Identidad
 */
class ContractController extends Controller
{
    /**
     * GET /contracts/{uuid}
     * Visualiza el contrato para firma (Vista de Consentimiento con OTP flow).
     */
    public function show(string $uuid): void
    {
        try {
            $pdo  = Connection::getInstance();
            $stmt = $pdo->prepare("SELECT * FROM contracts WHERE uuid = :u LIMIT 1");
            $stmt->execute(['u' => $uuid]);
            $contract = $stmt->fetch();

            if (!$contract) {
                http_response_code(404);
                echo "<h1>Contrato no encontrado.</h1>";
                return;
            }

            // Registrar visualización para auditoría (HIPAA Trace)
            $pdo->prepare("
                INSERT INTO contract_audit (contract_id, event_type, ip_address, details)
                VALUES (:id, 'VIEW', :ip, 'Contrato visualizado por el cliente.')
            ")->execute([
                'id' => $contract['id'],
                'ip' => $_SERVER['REMOTE_ADDR'] ?? 'UNKNOWN',
            ]);

            AuditService::log(null, 'CONTRACT_VIEW', 'contracts', (int)$contract['id'], "UUID: $uuid");

            $this->view('Contracts/Views/show', [
                'contract' => $contract,
                'isSigned' => ($contract['status'] === 'signed'),
                'otpVerified' => (bool)($contract['otp_verified'] ?? false),
            ]);

        } catch (Exception $e) {
            error_log("[IMO][Contract] Error: " . $e->getMessage());
            http_response_code(500);
            echo "Error al cargar el documento.";
        }
    }

    /**
     * POST /contracts/{uuid}/otp/request
     * Genera y envía un OTP al email del firmante.
     */
    public function requestOtp(string $uuid): void
    {
        header('Content-Type: application/json');
        try {
            $pdo  = Connection::getInstance();
            $stmt = $pdo->prepare("SELECT id, status, contact_email FROM contracts WHERE uuid = :u LIMIT 1");
            $stmt->execute(['u' => $uuid]);
            $contract = $stmt->fetch();

            if (!$contract) {
                $this->json(['status' => 'error', 'message' => 'Contrato no encontrado.'], 404);
                return;
            }

            if ($contract['status'] === 'signed') {
                $this->json(['status' => 'error', 'message' => 'Este contrato ya fue firmado.'], 409);
                return;
            }

            $input = json_decode(file_get_contents('php://input'), true);
            $email = trim(filter_var($input['email'] ?? $contract['contact_email'] ?? '', FILTER_SANITIZE_EMAIL));

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $this->json(['status' => 'error', 'message' => 'Email inválido o no registrado en este contrato.'], 422);
                return;
            }

            // Guardar/actualizar email de contacto si no estaba
            if (empty($contract['contact_email'])) {
                $pdo->prepare("UPDATE contracts SET contact_email = :email WHERE id = :id")
                    ->execute(['email' => $email, 'id' => $contract['id']]);
            }

            $ip      = $_SERVER['REMOTE_ADDR'] ?? 'UNKNOWN';
            $success = OtpService::generate((int)$contract['id'], $email, $ip);

            if ($success) {
                AuditService::log(null, 'OTP_SENT', 'contracts', (int)$contract['id'], "OTP enviado a: $email");
                $masked = substr($email, 0, 3) . '***' . substr(strrchr($email, '@'), 0);
                $this->json(['status' => 'success', 'message' => "Código enviado a $masked. Válido 10 minutos."]);
            } else {
                $this->json(['status' => 'error', 'message' => 'No se pudo enviar el código. Intenta de nuevo.'], 500);
            }

        } catch (Exception $e) {
            $this->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * POST /contracts/{uuid}/otp/verify
     * Valida el OTP recibido y activa el paso de firma.
     */
    public function verifyOtp(string $uuid): void
    {
        header('Content-Type: application/json');
        try {
            $pdo  = Connection::getInstance();
            $stmt = $pdo->prepare("SELECT id, status FROM contracts WHERE uuid = :u LIMIT 1");
            $stmt->execute(['u' => $uuid]);
            $contract = $stmt->fetch();

            if (!$contract) {
                $this->json(['status' => 'error', 'message' => 'Contrato no encontrado.'], 404);
                return;
            }

            $input = json_decode(file_get_contents('php://input'), true);
            $code  = trim($input['otp'] ?? '');

            if (strlen($code) !== 6 || !ctype_digit($code)) {
                $this->json(['status' => 'error', 'message' => 'El código debe ser de 6 dígitos.'], 422);
                return;
            }

            $ip     = $_SERVER['REMOTE_ADDR'] ?? 'UNKNOWN';
            $result = OtpService::verify((int)$contract['id'], $code, $ip);

            if ($result['ok']) {
                AuditService::log(null, 'OTP_VERIFIED', 'contracts', (int)$contract['id'], "OTP verificado desde: $ip");
            }

            $this->json([
                'status'  => $result['ok'] ? 'success' : 'error',
                'message' => $result['message'],
            ], $result['ok'] ? 200 : 422);

        } catch (Exception $e) {
            $this->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * POST /contracts/{uuid}/sign
     * Procesa la firma digital Click-to-Sign (requiere OTP verificado).
     */
    public function sign(string $uuid): void
    {
        header('Content-Type: application/json');
        try {
            $pdo  = Connection::getInstance();
            $stmt = $pdo->prepare("SELECT id, otp_verified FROM contracts WHERE uuid = :u LIMIT 1");
            $stmt->execute(['u' => $uuid]);
            $contract = $stmt->fetch();

            if (!$contract) {
                $this->json(['status' => 'error', 'message' => 'Contrato inexistente.'], 404);
                return;
            }

            // Guardia: OTP debe estar verificado
            if (!(bool)$contract['otp_verified']) {
                $this->json([
                    'status'  => 'error',
                    'message' => 'Debes verificar tu identidad con el código OTP antes de firmar.',
                    'code'    => 'OTP_REQUIRED',
                ], 403);
                return;
            }

            $ip      = $_SERVER['REMOTE_ADDR'] ?? 'UNKNOWN';
            $success = SignatureService::sign((int)$contract['id'], $ip);

            if ($success) {
                AuditService::log(null, 'CONTRACT_SIGNED', 'contracts', (int)$contract['id'], "Firmado desde IP: $ip");
                $this->json([
                    'status'  => 'success',
                    'message' => 'Contrato firmado digitalmente con éxito (HIPAA Verified).',
                ]);
            } else {
                $this->json(['status' => 'error', 'message' => 'Fallo en la generación de la firma digital.'], 500);
            }

        } catch (Exception $e) {
            $this->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }
}
