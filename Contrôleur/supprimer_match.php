<?php
require_once '../Modéle/db_connection.php';

if (isset($_GET['id'])) {
    $idMatch = $_GET['id'];

    try {
        $db = connectDB();

        // Supprimer les participations liées au match
        $deleteParticipationQuery = "DELETE FROM Participer WHERE Id_Match = :id";
        $deleteParticipationStmt = $db->prepare($deleteParticipationQuery);
        $deleteParticipationStmt->execute([':id' => $idMatch]);

        // Supprimer le match
        $deleteMatchQuery = "DELETE FROM Matchs WHERE Id_Match = :id";
        $deleteMatchStmt = $db->prepare($deleteMatchQuery);
        $deleteMatchStmt->execute([':id' => $idMatch]);

        header('Location: ../Vue/php/Liste_Match.php?message=success');
        exit;
    } catch (PDOException $e) {
        echo "Erreur lors de la suppression : " . $e->getMessage();
    }
} else {
    echo "ID du match non spécifié.";
}
?>
