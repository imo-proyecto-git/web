<?php

namespace IMO\Core\Infrastructure;

use IMO\Core\Database\Connection;
use Exception;

/**
 * QueueService — Motor de Cola de Trabajos Background
 * empresaIMO — Arquitectura de Alta Disponibilidad
 *
 * Encola cualquier job en la tabla job_queue para ser procesado
 * por el worker CLI independiente (worker.php), liberando
 * inmediatamente la respuesta HTTP al usuario.
 */
class QueueService
{
    // Nombres de colas disponibles
    public const QUEUE_EMAILS   = 'emails';
    public const QUEUE_REPORTS  = 'reports';
    public const QUEUE_DEFAULT  = 'default';

    /**
     * Encola un trabajo para procesamiento asíncrono.
     *
     * @param  string $queue    Nombre de la cola (usar constantes)
     * @param  string $jobClass Clase handler a ejecutar (FQCN)
     * @param  array  $payload  Datos del trabajo (serializables en JSON)
     * @param  int    $delaySeconds Segundos de espera antes de disponibilidad
     * @return int    ID del job insertado
     */
    public static function dispatch(
        string $queue,
        string $jobClass,
        array  $payload,
        int    $delaySeconds = 0
    ): int {
        try {
            $pdo = Connection::getInstance();

            $availableAt = date('Y-m-d H:i:s', time() + $delaySeconds);
            $serialized  = json_encode([
                'class'   => $jobClass,
                'payload' => $payload,
            ], JSON_UNESCAPED_UNICODE);

            $stmt = $pdo->prepare("
                INSERT INTO job_queue (queue, payload, available_at)
                VALUES (:queue, :payload, :available_at)
            ");
            $stmt->execute([
                'queue'        => $queue,
                'payload'      => $serialized,
                'available_at' => $availableAt,
            ]);

            return (int)$pdo->lastInsertId();

        } catch (Exception $e) {
            error_log("[IMO][Queue] Error despachando job: " . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Obtiene el siguiente job disponible (con bloqueo pesimista).
     * Marca el job como 'processing' atómicamente para evitar race conditions.
     */
    public static function dequeue(string $queue = self::QUEUE_DEFAULT): ?array
    {
        try {
            $pdo = Connection::getInstance();
            $pdo->beginTransaction();

            $stmt = $pdo->prepare("
                SELECT * FROM job_queue
                WHERE queue = :queue
                  AND status = 'pending'
                  AND available_at <= NOW()
                  AND attempts < max_attempts
                ORDER BY id ASC
                LIMIT 1
                FOR UPDATE SKIP LOCKED
            ");
            $stmt->execute(['queue' => $queue]);
            $job = $stmt->fetch(\PDO::FETCH_ASSOC);

            if (!$job) {
                $pdo->rollBack();
                return null;
            }

            $pdo->prepare("
                UPDATE job_queue
                SET status = 'processing', started_at = NOW(), attempts = attempts + 1
                WHERE id = :id
            ")->execute(['id' => $job['id']]);

            $pdo->commit();

            $job['data'] = json_decode($job['payload'], true);
            return $job;

        } catch (Exception $e) {
            $pdo->rollBack();
            error_log("[IMO][Queue] Error en dequeue: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Marca un job como completado exitosamente.
     */
    public static function markDone(int $jobId): void
    {
        try {
            Connection::getInstance()->prepare("
                UPDATE job_queue SET status = 'done', done_at = NOW()
                WHERE id = :id
            ")->execute(['id' => $jobId]);
        } catch (Exception $e) {
            error_log("[IMO][Queue] Error en markDone: " . $e->getMessage());
        }
    }

    /**
     * Marca un job como fallido con razón de error.
     * Si excede max_attempts, queda en estado 'failed' definitivo.
     */
    public static function markFailed(int $jobId, string $reason): void
    {
        try {
            $pdo = Connection::getInstance();

            $stmt = $pdo->prepare("SELECT attempts, max_attempts FROM job_queue WHERE id = :id");
            $stmt->execute(['id' => $jobId]);
            $job = $stmt->fetch(\PDO::FETCH_ASSOC);

            $newStatus = ($job && (int)$job['attempts'] >= (int)$job['max_attempts'])
                ? 'failed'
                : 'pending'; // Reintento

            $pdo->prepare("
                UPDATE job_queue
                SET status = :status, failed_reason = :reason, started_at = NULL
                WHERE id = :id
            ")->execute([
                'status' => $newStatus,
                'reason' => substr($reason, 0, 65535),
                'id'     => $jobId,
            ]);

        } catch (Exception $e) {
            error_log("[IMO][Queue] Error en markFailed: " . $e->getMessage());
        }
    }

    /**
     * Estadísticas del sistema de colas.
     */
    public static function stats(): array
    {
        try {
            $pdo  = Connection::getInstance();
            $stmt = $pdo->query("
                SELECT queue, status, COUNT(*) as total
                FROM job_queue
                GROUP BY queue, status
            ");
            $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);

            $result = [];
            foreach ($rows as $row) {
                $result[$row['queue']][$row['status']] = (int)$row['total'];
            }
            return $result;

        } catch (Exception $e) {
            return [];
        }
    }
}
