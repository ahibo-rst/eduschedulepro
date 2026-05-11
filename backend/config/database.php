<?php
define('DB_HOST', 'localhost');
define('DB_NAME', 'eduschedulepro');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_CHARSET', 'utf8mb4');

define('JWT_SECRET', 'CHANGEZ_CETTE_CLE_EN_PRODUCTION_2026');
define('JWT_EXPIRY', 86400);
define('QR_WINDOW', 900);

function getPDO(): PDO {
    static $pdo = null;
    if ($pdo === null) {
        $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET;
        try {
            $pdo = new PDO($dsn, DB_USER, DB_PASS, [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ]);
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Erreur de connexion à la base de données']);
            exit;
        }
    }
    return $pdo;
}