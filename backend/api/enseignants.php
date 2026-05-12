<?php
error_reporting(0);
ini_set('display_errors', 0);
require_once __DIR__ . '/../config/cors.php';
require_once __DIR__ . '/../config/database.php';

$pdo = getPDO();
$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'GET') {
    $stmt = $pdo->prepare("SELECT * FROM enseignants ORDER BY nom");
    $stmt->execute();
    jsonSuccess($stmt->fetchAll());
}

if ($method === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    
    if (!isset($data['nom']) || !isset($data['email'])) {
        jsonErreur('Nom et email requis', 400);
    }
    
    $stmt = $pdo->prepare("INSERT INTO enseignants (nom, email, telephone, specialite) VALUES (?, ?, ?, ?)");
    $stmt->execute([
        $data['nom'],
        $data['email'],
        $data['telephone'] ?? null,
        $data['specialite'] ?? null
    ]);
    
    jsonSuccess(['id' => $pdo->lastInsertId()], 201);
}

if ($method === 'DELETE') {
    $id = $_GET['id'] ?? null;
    if (!$id) jsonErreur('ID requis', 400);
    
    $stmt = $pdo->prepare("DELETE FROM enseignants WHERE id = ?");
    $stmt->execute([$id]);
    jsonSuccess(['message' => 'Enseignant supprimé']);
}
?>