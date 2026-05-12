<?php
error_reporting(0);
ini_set('display_errors', 0);
require_once  __DIR__ '../middleware/auth.php';
require_once  __DIR__ '../config/database.php';

$db = getDBConnection();
$method = $_SERVER['REQUEST_METHOD'];

switch($method) {
    case 'GET':
        $stmt = $db->query("SELECT * FROM matieres ORDER BY libelle");
        $matieres = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode(['success' => true, 'data' => $matieres]);
        break;

    case 'POST':
        $data = json_decode(file_get_contents('php://input'), true);
        $stmt = $db->prepare("INSERT INTO matieres (nom, code, coefficient) VALUES (?, ?, ?)");
        $stmt->execute([$data['nom'], $data['code'], $data['coefficient']]);
        echo json_encode(['success' => true, 'message' => 'Matière ajoutée']);
        break;

    case 'PUT':
        $data = json_decode(file_get_contents('php://input'), true);
        $stmt = $db->prepare("UPDATE matieres SET nom=?, code=?, coefficient=? WHERE id=?");
        $stmt->execute([$data['nom'], $data['code'], $data['coefficient'], $data['id']]);
        echo json_encode(['success' => true, 'message' => 'Matière modifiée']);
        break;

    case 'DELETE':
        $id = $_GET['id'];
        $stmt = $db->prepare("DELETE FROM matieres WHERE id=?");
        $stmt->execute([$id]);
        echo json_encode(['success' => true, 'message' => 'Matière supprimée']);
        break;
}
?>