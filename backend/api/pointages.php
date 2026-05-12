<?php
error_reporting(0);
ini_set('display_errors', 0);
require_once _DIR_ . '/../config/cors.php';
require_once _DIR_ . '/../config/database.php';
require_once _DIR_ . '/../middleware/auth.php';

$pdo = getPDO();
$utilisateur = verifierToken($pdo);
$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'GET') {
    $enseignant_id = $_GET['enseignant_id'] ?? null;
    $date = $_GET['date'] ?? date('Y-m-d');
    
    $sql = "SELECT p.*, e.nom as enseignant_nom, 
            m.nom as matiere_nom, c.nom as classe_nom
            FROM pointages p
            JOIN enseignants e ON p.enseignant_id = e.id
            JOIN matieres m ON p.matiere_id = m.id
            JOIN classes c ON p.classe_id = c.id
            WHERE DATE(p.date_pointage) = ?";
    
    $params = [$date];
    
    if ($enseignant_id) {
        $sql .= " AND p.enseignant_id = ?";
        $params[] = $enseignant_id;
    }
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    jsonSuccess($stmt->fetchAll());
}

if ($method === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    
    $stmt = $pdo->prepare("INSERT INTO pointages 
        (enseignant_id, classe_id, matiere_id, date_pointage, heure_arrivee, statut) 
        VALUES (?, ?, ?, ?, ?, ?)");
    
    $stmt->execute([
        $data['enseignant_id'],
        $data['classe_id'],
        $data['matiere_id'],
        $data['date_pointage'],
        $data['heure_arrivee'],
        $data['statut'] ?? 'present'
    ]);
    
    jsonSuccess(['id' => $pdo->lastInsertId()], 201);
}
?>