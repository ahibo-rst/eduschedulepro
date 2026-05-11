<?php
require_once '../middleware/auth.php';
require_once '../config/database.php';

$db = getDBConnection();
$method = $_SERVER['REQUEST_METHOD'];

switch($method) {
    case 'GET':
        $stmt = $db->query("SELECT id, nom, prenom, email, role FROM utilisateurs ORDER BY nom");
        $utilisateurs = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode(['success' => true, 'data' => $utilisateurs]);
        break;

    case 'POST':
        $data = json_decode(file_get_contents('php://input'), true);
        $password_hash = password_hash($data['password'], PASSWORD_DEFAULT);
        $stmt = $db->prepare("INSERT INTO utilisateurs (nom, prenom, email, password, role) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$data['nom'], $data['prenom'], $data['email'], $password_hash, $data['role']]);
        echo json_encode(['success' => true, 'message' => 'Utilisateur ajouté']);
        break;

    case 'PUT':
        $data = json_decode(file_get_contents('php://input'), true);
        $stmt = $db->prepare("UPDATE utilisateurs SET nom=?, prenom=?, email=?, role=? WHERE id=?");
        $stmt->execute([$data['nom'], $data['prenom'], $data['email'], $data['role'], $data['id']]);
        echo json_encode(['success' => true, 'message' => 'Utilisateur modifié']);
        break;

    case 'DELETE':
        $id = $_GET['id'];
        $stmt = $db->prepare("DELETE FROM utilisateurs WHERE id=?");
        $stmt->execute([$id]);
        echo json_encode(['success' => true, 'message' => 'Utilisateur supprimé']);
        break;
}
?>