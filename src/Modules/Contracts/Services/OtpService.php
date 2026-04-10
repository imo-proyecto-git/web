<?php

namespace IMO\Modules\Contracts\Services;

use IMO\Core\Database\Connection;
use IMO\Modules\Marketing\Services\MailerService;
use Exception;

/**
 * OtpService - Generación y validación de OTP para firma digital
 * empresaIMO — HIPAA Compliance: código de un solo uso, expiración 10 min.
 */
class OtpService
{
    private const OTP_EXPIRY_MINUTES = 10;
    private const MAX_ATTEMPTS       = 3;

    // ─── Generación ──────────────────────────────────────────────────────────

    /**
     * Genera un OTP de 6 dígitos, lo persiste y lo envía al correo del firmante.
     */
    public static function generate(int $contractId, string $email, string $ip): bool
    {
        try {
            $pdo  = Connection::getInstance();
            $code = str_pad((string)random_int(0, 999999), 6, '0', STR_PAD_LEFT);
            $exp  = date('Y-m-d H:i:s', strtotime('+' . self::OTP_EXPIRY_MINUTES . ' minutes'));

            // Invalidar OTPs previos para este contrato
            $pdo->prepare("UPDATE contract_otps SET used_at = NOW() WHERE contract_id = :cid AND used_at IS NULL")
                ->execute(['cid' => $contractId]);

            // Insertar nuevo OTP
            $stmt = $pdo->prepare("
                INSERT INTO contract_otps (contract_id, otp_code, email, expires_at, ip_address)
                VALUES (:cid, :code, :email, :exp, :ip)
            ");
            $stmt->execute([
                'cid'   => $contractId,
                'code'  => $code,
                'email' => $email,
                'exp'   => $exp,
                'ip'    => $ip,
            ]);

            // Enviar OTP por email
            return self::sendOtpEmail($email, $code);

        } catch (Exception $e) {
            error_log("[IMO][OTP] Error generando OTP: " . $e->getMessage());
            return false;
        }
    }

    // ─── Validación ──────────────────────────────────────────────────────────

    /**
     * Valida el OTP ingresado. Devuelve true si es válido y lo marca como usado.
     * Aplica limite de intentos para prevenir brute-force (HIPAA §164.312).
     */
    public static function verify(int $contractId, string $inputCode, string $ip): array
    {
        try {
            $pdo = Connection::getInstance();

            $stmt = $pdo->prepare("
                SELECT * FROM contract_otps
                WHERE contract_id = :cid
                  AND used_at IS NULL
                  AND expires_at > NOW()
                ORDER BY id DESC LIMIT 1
            ");
            $stmt->execute(['cid' => $contractId]);
            $otp = $stmt->fetch();

            if (!$otp) {
                return ['ok' => false, 'message' => 'El código ha expirado. Solicita uno nuevo.'];
            }

            // Incrementar intentos
            $pdo->prepare("UPDATE contract_otps SET attempts = attempts + 1 WHERE id = :id")
                ->execute(['id' => $otp['id']]);

            if ((int)$otp['attempts'] >= self::MAX_ATTEMPTS) {
                $pdo->prepare("UPDATE contract_otps SET used_at = NOW() WHERE id = :id")
                    ->execute(['id' => $otp['id']]);
                return ['ok' => false, 'message' => 'Límite de intentos excedido. Solicita un nuevo código.'];
            }

            if (!hash_equals($otp['otp_code'], trim($inputCode))) {
                $remaining = self::MAX_ATTEMPTS - (int)$otp['attempts'] - 1;
                return ['ok' => false, 'message' => "Código incorrecto. Intentos restantes: $remaining."];
            }

            // Marcar como usado
            $pdo->prepare("UPDATE contract_otps SET used_at = NOW() WHERE id = :id")
                ->execute(['id' => $otp['id']]);

            // Marcar contrato como OTP verificado
            $pdo->prepare("UPDATE contracts SET otp_verified = 1 WHERE id = :cid")
                ->execute(['cid' => $contractId]);

            return ['ok' => true, 'message' => 'Identidad verificada exitosamente.'];

        } catch (Exception $e) {
            error_log("[IMO][OTP] Error verificando OTP: " . $e->getMessage());
            return ['ok' => false, 'message' => 'Error del servidor al verificar el código.'];
        }
    }

    // ─── Mailer ──────────────────────────────────────────────────────────────

    private static function sendOtpEmail(string $email, string $code): bool
    {
        $companyName = config('app.company.name');
        $appUrl      = config('app.url', '');

        $html = <<<HTML
<!DOCTYPE html>
<html lang="es">
<head><meta charset="UTF-8"><title>Código de Verificación</title></head>
<body style="margin:0;padding:0;background:#f0f4ff;font-family:'Helvetica Neue',Arial,sans-serif;">
  <table width="100%" cellpadding="0" cellspacing="0" style="background:#f0f4ff;padding:40px 0;">
    <tr><td align="center">
      <table width="560" style="background:#ffffff;border-radius:24px;overflow:hidden;box-shadow:0 20px 60px rgba(0,17,58,.12);">
        <!-- Header -->
        <tr><td style="background:#00113a;padding:40px 48px;">
          <p style="color:#4edea3;font-size:11px;font-weight:800;letter-spacing:.2em;text-transform:uppercase;margin:0 0 8px;">{$companyName} — HIPAA SECURE</p>
          <h1 style="color:#ffffff;font-size:28px;font-weight:900;margin:0;letter-spacing:-1px;">Verificación de Firma Digital</h1>
        </td></tr>
        <!-- Body -->
        <tr><td style="padding:48px;">
          <p style="color:#334155;font-size:15px;line-height:1.7;margin:0 0 32px;">Has solicitado firmar un documento legal en {$companyName}. Ingresa el siguiente código único para confirmar tu identidad:</p>
          <!-- OTP Code -->
          <div style="background:#f8faff;border:2px dashed #c7d2fe;border-radius:16px;padding:32px;text-align:center;margin:0 0 32px;">
            <p style="color:#6b7280;font-size:11px;font-weight:800;letter-spacing:.2em;text-transform:uppercase;margin:0 0 12px;">Tu código de verificación</p>
            <p style="color:#00113a;font-size:48px;font-weight:900;letter-spacing:16px;margin:0;font-variant-numeric:tabular-nums;">{$code}</p>
            <p style="color:#94a3b8;font-size:11px;font-weight:600;margin:12px 0 0;">Válido por 10 minutos · Un solo uso</p>
          </div>
          <p style="color:#94a3b8;font-size:12px;line-height:1.7;margin:0;">Si no solicitaste firmar ningún documento, ignora este correo. Tu cuenta está segura.</p>
        </td></tr>
        <!-- Footer -->
        <tr><td style="background:#f8faff;border-top:1px solid #e2e8f0;padding:24px 48px;">
          <p style="color:#94a3b8;font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:.15em;margin:0;">🔒 HIPAA COMPLIANT · TLS 1.3 SECURE · {$companyName} DIGITAL</p>
        </td></tr>
      </table>
    </td></tr>
  </table>
</body>
</html>
HTML;

        $mailer = new MailerService();
        return $mailer->send($email, "[$companyName] Tu código de verificación: $code", $html);
    }
}
