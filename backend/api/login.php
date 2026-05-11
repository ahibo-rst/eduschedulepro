<?php
error_reporting(0);
ini_set('display_errors', 0);
require_once __DIR__ . '/../config/cors.php';
require_once __DIR__ . '/../config/database.php';

$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['email']) || !isset($data['password'])) {
    echo json_encode(['success' => false, 'message' => 'Email et mot de passe requis']);
    exit;
}

$pdo = getPDO();
$stmt = $pdo->prepare("SELECT * FROM utilisateurs WHERE email = ?");
$stmt->execute([$data['email']]);
$utilisateur = $stmt->fetch();

if (!$utilisateur || !password_verify($data['password'], $utilisateur['mot_de_passe_hash'])) {
    echo json_encode(['success' => false, 'message' => 'Email ou mot de passe incorrect']);
    exit;
}

$token = bin2hex(random_bytes(32));
$expiry = date('Y-m-d H:i:s', time() + 86400);

$stmt = $pdo->prepare("UPDATE utilisateurs SET token = ?, token_expiry = ? WHERE id = ?");
$stmt->execute([$token, $expiry, $utilisateur['id']]);

echo json_encode([
    'success' => true,
    'token' => $token,
    'user' => [
        'id' => $utilisateur['id'],
        'nom' => $utilisateur['nom'],
        'role' => $utilisateur['role']
    ]
]);
?>