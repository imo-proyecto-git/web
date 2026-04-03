<?php
// Diagnóstico completo - acceder como: /empresaIMO/public/diag.php
// Cada línea muestra en qué punto llegamos

// Test 1: PHP básico
header('Content-Type: text/plain; charset=utf-8');
echo "1. PHP OK\n";
flush();

// Test 2: Cargar .env
$envPath = __DIR__ . '/../.env';
echo "2. .env existe: " . (file_exists($envPath) ? "SI" : "NO") . "\n";
flush();

// Test 3: Leer .env  
$lines = file($envPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
echo "3. .env lineas: " . count($lines) . "\n";
flush();

// Test 4: Session (este es el que suele colgarse)
echo "4. Iniciando session...\n";
flush();
session_start();
echo "5. Session OK - ID: " . substr(session_id(), 0, 8) . "...\n";
flush();

// Test 5: Conexión DB
echo "6. Intentando conexion DB...\n";
flush();
try {
    $pdo = new PDO(
        "mysql:host=127.0.0.1;port=3306;dbname=empresaIMO_db;charset=utf8mb4",
        "root",
        "",
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_TIMEOUT => 3]
    );
    echo "7. DB OK - Conectado!\n";
    flush();
    $r = $pdo->query("SELECT COUNT(*) as c FROM users")->fetch();
    echo "8. Usuarios en BD: " . $r['c'] . "\n";
    flush();
} catch (Exception $e) {
    echo "7. DB ERROR: " . $e->getMessage() . "\n";
    flush();
}

echo "9. FIN - Todo completado.\n";
