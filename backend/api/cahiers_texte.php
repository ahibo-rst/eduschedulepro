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
    $classe_id = $_GET['classe_id'] ?? null;
    $enseignant_id = $_GET['enseignant_id'] ?? null;
    
    $sql = "SELECT ct.*, e.nom as enseignant_nom, 
            m.nom as matiere_nom, c.nom as classe_nom
            FROM cahiers_texte ct
            JOIN enseignants e ON ct.enseignant_id = e.id
            JOIN matieres m ON ct.matiere_id = m.id
            JOIN classes c ON ct.classe_id = c.id
            WHERE 1=1";
    
    $params = [];
    
    if ($classe_id) {
        $sql .= " AND ct.classe_id = ?";
        $params[] = $classe_id;
    }
    
    if ($enseignant_id) {
        $sql .= " AND ct.enseignant_id = ?";
        $params[] = $enseignant_id;
    }
    
    $sql .= " ORDER BY ct.date_cours DESC";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    jsonSuccess($stmt->fetchAll());
}

if ($method === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    
    $stmt = $pdo->prepare("INSERT INTO cahiers_texte 
        (enseignant_id, classe_id, matiere_id, date_cours, contenu, devoirs) 
        VALUES (?, ?, ?, ?, ?, ?)");
    
    $stmt->execute([
        $data['enseignant_id'],
        $data['classe_id'],
        $data['matiere_id'],
        $data['date_cours'],
        $data['contenu'],
        $data['devoirs'] ?? null
    ]);
    
    jsonSuccess(['id' => $pdo->lastInsertId()], 201);
}
?>