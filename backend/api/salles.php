<?php
error_reporting(0);
ini_set('display_errors', 0);
require_once __DIR__ . '/../config/cors.php';
require_once __DIR__ . '/../config/database.php';

$db = getDBConnection();
$method = $_SERVER['REQUEST_METHOD'];

switch($method) {
    case 'GET':
        $stmt = $db->query("SELECT * FROM salles ORDER BY code");
        $salles = $stmt->fetchAll(PDO::FETCH_ASSOC);
 \       echo json_encode(['success' => true, 'data' => $salles]);
        break;

    case 'POST':
        $data = json_decode(file_get_contents('php://input'), true);
        $stmt = $db->prepare("INSERT INTO salles (nom, capacite, type) VALUES (?, ?, ?)");
        $stmt->execute([$data['nom'], $data['capacite'], $data['type']]);
        echo json_encode(['success' => true, 'message' => 'Salle ajoutée']);
        break;

    case 'PUT':
        $data = json_decode(file_get_contents('php://input'), true);
        $stmt = $db->prepare("UPDATE salles SET nom=?, capacite=?, type=? WHERE id=?");
        $stmt->execute([$data['nom'], $data['capacite'], $data['type'], $data['id']]);
        echo
}