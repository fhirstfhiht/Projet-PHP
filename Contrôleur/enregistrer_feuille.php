<?php
include_once '../Modéle/db_connection.php';

$pdo = connectDB();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $idMatch = $_POST['Id_Match'];
    $participations = $_POST['participation'];

    foreach ($participations as $numeroLicence => $detailsParticipation) {
        $statutParticipation = $detailsParticipation['statut'];
        $posteMatch = $detailsParticipation['poste']; // Poste sélectionné pour ce match

        // Validation supplémentaire si nécessaire
        $validPostes = ['Ailier', 'Meneur', 'Arrière', 'Ailier Fort', 'Pivot'];
        if (!in_array($posteMatch, $validPostes)) {
            continue; // Ignorer si le poste n'est pas valide
        }

        try {
            // Insérer dans la table `participer`
            $insertQuery = $pdo->prepare(
                "INSERT INTO participer (Numero_Licence, Id_Match, Statut_Participation, Poste_Match)
                 VALUES (:numeroLicence, :idMatch, :statutParticipation, :posteMatch)"
            );
            $insertQuery->execute([
                ':numeroLicence' => $numeroLicence,
                ':idMatch' => $idMatch,
                ':statutParticipation' => $statutParticipation,
                ':posteMatch' => $posteMatch,
            ]);
        } catch (PDOException $e) {
            echo "<div class='error'>Erreur lors de l'insertion : " . htmlspecialchars($e->getMessage()) . "</div>";
            exit;
        }
    }

    // Redirection en cas de succès
    header("Location: /Projet_php/Vue/php/Feuilles_de_Matchs.php?success=1");
    exit;
} else {
    echo "<div class='error'>Aucune donnée soumise.</div>";
}
?>
