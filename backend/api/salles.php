<?php
require_once '../middleware/auth.php';
require_once '../config/database.php';

$db = getDBConnection();
$method = $_SERVER['REQUEST_METHOD'];

switch($method) {
    case 'GET':
        $stmt = $db->query("SELECT * FROM salles ORDER BY nom");
        $salles = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode(['success' => true, 'data' => $salles]);
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