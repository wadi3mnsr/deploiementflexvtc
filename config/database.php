<?php
/**
 * config/database.php
 * Connexion PDO à MySQL
 */

require_once __DIR__ . '/app.php';

try {
    // DSN
    $dsn = sprintf(
        'mysql:host=%s;dbname=%s;charset=utf8mb4',
        $_ENV['DB_HOST'],
        $_ENV['DB_NAME']
    );

    // Options PDO
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // Exceptions en cas d'erreur
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       // fetch assoc par défaut
        PDO::ATTR_EMULATE_PREPARES   => false,                  // use real prepared statements
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci"
    ];

    // Connexion
    $pdo = new PDO($dsn, $_ENV['DB_USER'], $_ENV['DB_PASS'], $options);

} catch (Throwable $e) {
    if (APP_DEBUG) {
        die("❌ Erreur connexion MySQL : " . $e->getMessage());
    } else {
        error_log("[MySQL] " . $e->getMessage());
        http_response_code(500);
        die("Erreur de connexion à la base MySQL.");
    }
}

return $pdo;
