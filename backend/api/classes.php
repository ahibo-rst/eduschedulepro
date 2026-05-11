<?php
require_once _DIR_ . '/../config/cors.php';
require_once _DIR_ . '/../config/database.php';
require_once _DIR_ . '/../middleware/auth.php';

$pdo = getPDO();
$utilisateur = verifierToken($pdo);
$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'GET') {
    $stmt = $pdo->prepare("SELECT * FROM classes ORDER BY nom");
    $stmt->execute();
    jsonSuccess($stmt->fetchAll());
}

if ($method === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    
    if (!isset($data['nom'])) {
        jsonErreur('Nom de la classe requis', 400);
    }
    
    $stmt = $pdo->prepare("INSERT INTO classes (nom, niveau, effectif) VALUES (?, ?, ?)");
    $stmt->execute([
        $data['nom'],
        $data['niveau'] ?? null,
        $data['effectif'] ?? 0
    ]);
    
    jsonSuccess(['id' => $pdo->lastInsertId()], 201);
}

if ($method === 'DELETE') {
    $id = $_GET['id'] ?? null;
    if (!$id) jsonErreur('ID requis', 400);
    
    $stmt = $pdo->prepare("DELETE FROM classes WHERE id = ?");
    $stmt->execute([$id]);
    jsonSuccess(['message' => 'Classe supprimée']);
}
?>