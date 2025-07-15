<?php
// includes/config.php
define('DB_HOST', '127.0.0.1');
define('DB_NAME', 'organizador_db');
define('DB_USER', 'root');
define('DB_PASS', '');  // Pon aquí tu contraseña si la tuvieras

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO(
        "mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=utf8mb4",
        DB_USER,
        DB_PASS,
        $options
    );
} catch (PDOException $e) {
    exit('Error de conexión: ' . $e->getMessage());
}
