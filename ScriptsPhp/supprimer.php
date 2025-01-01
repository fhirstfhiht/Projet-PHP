<?php
// Activer les erreurs pour le débogage
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once '../SQL/db_connection.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    try {
        $db = connectDB();

        // Supprimer les références dans la table Participer
        $stmt = $db->prepare("DELETE FROM Participer WHERE Numero_Licence = ?");
        $stmt->execute([$id]);

        // Supprimer le joueur dans la table Joueurs
        $stmt = $db->prepare("DELETE FROM Joueurs WHERE Numero_Licence = ?");
        $success = $stmt->execute([$id]);

        echo json_encode(['success' => $success]);
    } catch (PDOException $e) {
        echo json_encode([
            'success' => false,
            'error' => 'Erreur lors de la suppression : ' . $e->getMessage()
        ]);
    }
} else {
    echo json_encode([
        'success' => false,
        'error' => 'Aucun ID fourni pour la suppression.'
    ]);
}
