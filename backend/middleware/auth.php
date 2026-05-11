<?php
require_once _DIR_ . '/../config/database.php';

function verifierToken($pdo) {
    $headers = getallheaders();
    
    if (!isset($headers['Authorization'])) {
        http_response_code(401);
        echo json_encode(['erreur' => 'Token manquant']);
        exit();
    }
    
    $token = str_replace('Bearer ', '', $headers['Authorization']);
    
    $stmt = $pdo->prepare("SELECT * FROM utilisateurs WHERE token = ? AND token_expiry > NOW()");
    $stmt->execute([$token]);
    $utilisateur = $stmt->fetch();
    
    if (!$utilisateur) {
        http_response_code(401);
        echo json_encode(['erreur' => 'Token invalide ou expiré']);
        exit();
    }
    
    return $utilisateur;
}
?>