<?php

namespace IMO\Modules\Audit\Services;

use IMO\Core\Database\Connection;
use Exception;

/**
 * AuditService - Centralized HIPAA Compliance Logger
 * empresaIMO
 */
class AuditService
{
    /**
     * Registra un evento de auditoría en la base de datos de forma inmutable.
     * 
     * @param int|null $userId ID del usuario que realizó la acción
     * @param string $action Tipo de acción (LOGIN, VIEW_PHI, EDIT_PHI, EXPORT)
     * @param string|null $table Tabla afectada (opcional)
     * @param int|null $recordId ID del registro afectado (opcional)
     * @param string|null $details Detalles adicionales de la acción
     */
    public static function log(?int $userId, string $action, ?string $table = null, ?int $recordId = null, ?string $details = null): void
    {
        try {
            $pdo = Connection::getInstance();
            $stmt = $pdo->prepare("
                INSERT INTO audit_logs 
                    (user_id, action, target_table, target_record_id, ip_address, user_agent, details) 
                VALUES (:u, :a, :t, :rid, :ip, :ua, :d)
            ");
            
            $stmt->execute([
                'u'   => $userId,
                'a'   => strtoupper($action),
                't'   => $table,
                'rid' => $recordId,
                'ip'  => $_SERVER['REMOTE_ADDR'] ?? 'CLI',
                'ua'  => $_SERVER['HTTP_USER_AGENT'] ?? 'CLI',
                'd'   => $details
            ]);

            // Se puede extender para enviar alertas a un SIEM externo si es necesario.
            
        } catch (Exception $e) {
            // No detenemos la ejecución si falla el log, pero lo registramos en el error_log del sistema
            error_log("[IMO][HIPAA][CRITICAL] Fallo en el registro de auditoría: " . $e->getMessage());
        }
    }

    /**
     * Recupera logs para un registro específico (Trazabilidad).
     */
    public static function getLogsForRecord(string $table, int $recordId): array
    {
        try {
            $pdo = Connection::getInstance();
            $stmt = $pdo->prepare("SELECT * FROM audit_logs WHERE target_table = :t AND target_record_id = :rid ORDER BY created_at DESC");
            $stmt->execute(['t' => $table, 'rid' => $recordId]);
            return $stmt->fetchAll();
        } catch (Exception $e) {
            return [];
        }
    }
}
