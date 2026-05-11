<?php
require_once _DIR_ . '/../config/cors.php';
require_once _DIR_ . '/../config/database.php';
require_once _DIR_ . '/../middleware/auth.php';

$pdo = getPDO();
$utilisateur = verifierToken($pdo);
$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'GET') {
    $classe_id = $_GET['classe_id'] ?? null;
    $enseignant_id = $_GET['enseignant_id'] ?? null;
    
    $sql = "SELECT et.*, c.nom as classe_nom, m.nom as matiere_nom, 
            e.nom as enseignant_nom, s.nom as salle_nom
            FROM emploi_temps et
            JOIN classes c ON et.classe_id = c.id
            JOIN matieres m ON et.matiere_id = m.id
            JOIN enseignants e ON et.enseignant_id = e.id
            JOIN salles s ON et.salle_id = s.id
            WHERE 1=1";
    
    $params = [];
    
    if ($classe_id) {
        $sql .= " AND et.classe_id = ?";
        $params[] = $classe_id;
    }
    
    if ($enseignant_id) {
        $sql .= " AND et.enseignant_id = ?";
        $params[] = $enseignant_id;
    }
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    jsonSuccess($stmt->fetchAll());
}
?>