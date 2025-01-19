<?php
session_start();
// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    // Si l'utilisateur n'est pas connecté, on le redirige vers la page de connexion
    header('Location: ../../php/Connexion.php');
    exit;
}

// Inclure les fichiers nécessaires
require_once '../Modéle/db_connection.php';
require_once '../Modéle/db_Feuilles_de_Matchs.php';

// Obtenir une connexion à la base de données
$pdo = connectDB();

// Vérifier si l'ID du match est spécifié
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['Id_Match']) || empty($_POST['Id_Match'])) {
        echo "Erreur : ID du match manquant.";
        exit;
    }

    $matchId = $_POST['Id_Match'];
    // Si le formulaire est soumis
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Mise à jour des postes, participations, commentaires et notes
        if (isset($_POST['poste']) && isset($_POST['participation'])) {
            foreach ($_POST['poste'] as $numeroLicence => $poste) {
                $participation = $_POST['participation'][$numeroLicence];
                $commentaire = $_POST['commentaire'][$numeroLicence] ?? null;
                $note = $_POST['note'][$numeroLicence] ?? null;

                // Mettre à jour le poste, la participation et les notes dans la table `participer`
                $updateParticipationQuery = $pdo->prepare("
                    UPDATE participer
                    SET Poste_Match = :poste, Statut_Participation = :participation, Note = :note
                    WHERE Numero_Licence = :numero_licence AND Id_Match = :match_id
                ");
                $updateParticipationQuery->execute([
                    'poste' => $poste,
                    'participation' => $participation,
                    'note' => $note,
                    'numero_licence' => $numeroLicence,
                    'match_id' => $matchId,
                ]);

                // Mettre à jour les commentaires dans la table `joueurs`
                $updateCommentQuery = $pdo->prepare("
                    UPDATE joueurs
                    SET Commentaires = :commentaire
                    WHERE Numero_Licence = :numero_licence
                ");
                $updateCommentQuery->execute([
                    'commentaire' => $commentaire,
                    'numero_licence' => $numeroLicence,
                ]);
            }
        }

        // Gestion de la suppression des joueurs
        if (isset($_POST['delete_player']) && !empty($_POST['Numero_Licence'])) {
            $deleteQuery = $pdo->prepare("
                DELETE FROM participer
                WHERE Numero_Licence = :numero_licence AND Id_Match = :match_id
            ");
            $deleteQuery->execute([
                'numero_licence' => $_POST['Numero_Licence'],
                'match_id' => $matchId,
            ]);
        }

        // Rediriger après les modifications
        header("Location: ../Vue/PHP/modifier_feuille_de_match.php?Id_Match=$matchId");
        exit;
    }

    // Charger les joueurs associés à la feuille de match
    $players = getPlayersForMatch($pdo, $matchId);
} else {
    echo "<p>ID du match non spécifié.</p>";
    exit;
}
?>
