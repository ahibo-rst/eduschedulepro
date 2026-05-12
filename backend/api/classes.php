<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);;
require_once __DIR__ . '/../config/cors.php';
require_once __DIR__ . '/../config/database.php';

$pdo = getPDO();
$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'GET') {
    $stmt = $pdo->prepare("SELECT * FROM classes ORDER BY libelle");
    $stmt->execute();
    jsonSuccess($stmt->fetchAll());
}
?>