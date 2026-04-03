<?php

namespace IMO\Modules\Contracts\Services;

use IMO\Core\Database\Connection;
use Exception;

/**
 * SignatureService - Click-to-sign / Integrity Proof
 * empresaIMO - HIPAA Compliance Standard
 */
class SignatureService
{
    /**
     * Firma digitalmente un contrato.
     * Genera un hash SHA-256 basado en el contenido del contrato, el ID del lead y la IP.
     */
    public static function sign(int $contractId, string $ipAddress): bool
    {
        try {
            $pdo = Connection::getInstance();
            
            // 1. Obtener datos del contrato
            $stmt = $pdo->prepare("SELECT * FROM contracts WHERE id = :id");
            $stmt->execute(['id' => $contractId]);
            $contract = $stmt->fetch();

            if (!$contract || $contract['status'] === 'signed') {
                throw new Exception("Contrato no apto para firma.");
            }

            // 2. Generar Hash de Integridad (Prueba Legal)
            $timestamp = date('Y-m-d H:i:s');
            $rawPayload = $contract['uuid'] . '|' . $contract['content'] . '|' . $ipAddress . '|' . $timestamp;
            $algo = config('app.sla.signature_algo', 'sha256');
            $hash = hash($algo, $rawPayload);

            // 3. Actualizar registro del contrato
            $update = $pdo->prepare("
                UPDATE contracts 
                SET status = 'signed', 
                    signature_hash = :h, 
                    ip_address = :ip, 
                    signed_at = :at 
                WHERE id = :id
            ");
            
            $update->execute([
                'h'  => $hash,
                'ip' => $ipAddress,
                'at' => $timestamp,
                'id' => $contractId
            ]);

            // 4. Registrar en Auditoría PHI-Secure
            $audit = $pdo->prepare("
                INSERT INTO contract_audit (contract_id, event_type, ip_address, details) 
                VALUES (:cid, 'SIGN', :ip, :det)
            ");
            $audit->execute([
                'cid' => $contractId,
                'ip'  => $ipAddress,
                'det' => "Firma digital generada. Hash verificador: $hash"
            ]);

            return true;

        } catch (Exception $e) {
            error_log("[IMO][Signature] Error: " . $e->getMessage());
            return false;
        }
    }
}
