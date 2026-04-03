<?php

namespace IMO\Modules\Contracts\Controllers;

use IMO\Core\Controller;
use IMO\Core\Database\Connection;
use IMO\Modules\Contracts\Services\SignatureService;
use Exception;

/**
 * ContractController - Módulo de Firma Digital
 * empresaIMO - Arquitectura Moderna
 */
class ContractController extends Controller
{
    /**
     * GET /contracts/{uuid}
     * Visualiza el contrato para firma (Vista de Consentimiento).
     */
    public function show(string $uuid): void
    {
        try {
            $pdo = Connection::getInstance();
            $stmt = $pdo->prepare("SELECT * FROM contracts WHERE uuid = :u LIMIT 1");
            $stmt->execute(['u' => $uuid]);
            $contract = $stmt->fetch();

            if (!$contract) {
                http_response_code(404);
                return;
            }

            // Registrar visualización para auditoría (HIPAA Trace)
            $audit = $pdo->prepare("INSERT INTO contract_audit (contract_id, event_type, ip_address, details) VALUES (:id, 'VIEW', :ip, 'Contrato visualizado por el cliente.')");
            $audit->execute([
                'id' => $contract['id'],
                'ip' => $_SERVER['REMOTE_ADDR'] ?? 'UNKNOWN'
            ]);

            $this->view('Contracts/Views/show', [
                'contract' => $contract,
                'isSigned' => ($contract['status'] === 'signed')
            ]);

        } catch (Exception $e) {
            error_log("[IMO][Contract] Error: " . $e->getMessage());
            die("Error al cargar el documento.");
        }
    }

    /**
     * POST /contracts/{uuid}/sign
     * Procesa la firma digital (Click-to-sign).
     */
    public function sign(string $uuid): void
    {
        try {
            $pdo = Connection::getInstance();
            $stmt = $pdo->prepare("SELECT id FROM contracts WHERE uuid = :u LIMIT 1");
            $stmt->execute(['u' => $uuid]);
            $contract = $stmt->fetch();

            if (!$contract) {
                $this->json(['status' => 'error', 'message' => 'Contrato inexistente.'], 404);
                return;
            }

            // Llamada al SignatureService
            $success = SignatureService::sign((int)$contract['id'], $_SERVER['REMOTE_ADDR'] ?? 'UNKNOWN');

            if ($success) {
                $this->json(['status' => 'success', 'message' => 'Contrato firmado digitalmente con éxito (HIPAA Verified).']);
            } else {
                $this->json(['status' => 'error', 'message' => 'Fallo en la generación de la firma digital.'], 500);
            }

        } catch (Exception $e) {
            $this->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }
}
