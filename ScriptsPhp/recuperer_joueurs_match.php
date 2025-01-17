<?php
include_once '../SQL/db_connection.php';

header('Content-Type: application/json'); // Important pour indiquer que la sortie est JSON

try {
    if (!isset($_GET['Id_Match']) || empty($_GET['Id_Match'])) {
        echo json_encode(['error' => 'ID du match manquant ou invalide']);
        exit;
    }

    $pdo = connectDB();
    $matchId = $_GET['Id_Match'];

    $query = $pdo->prepare("
        SELECT pa.Numero_Licence, j.Nom, j.Prenom, pa.Statut_Participation, pa.Note, j.Commentaires
        FROM `participer` pa
        JOIN `joueurs` j ON pa.Numero_Licence = j.Numero_Licence
        WHERE pa.Id_Match = :match_id
    ");
    $query->execute(['match_id' => $matchId]);

    $players = $query->fetchAll(PDO::FETCH_ASSOC);

    if (!$players) {
        echo json_encode(['error' => 'Aucun joueur trouvé pour ce match.']);
        exit;
    }

    echo json_encode($players); // Sortie des données sous forme JSON
} catch (Exception $e) {
    http_response_code(500); // Réponse HTTP 500 en cas d'erreur serveur
    echo json_encode(['error' => 'Erreur serveur : ' . $e->getMessage()]);
}
