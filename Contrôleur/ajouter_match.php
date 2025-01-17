<?php
require_once '../Modéle/db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dateHeure = $_POST['date_heure'];
    $adversaire = $_POST['adversaire'];
    $lieu = $_POST['lieu'];
    $scoreEquipe = (int) $_POST['score_equipe'];
    $scoreAdversaire = (int) $_POST['score_adversaire'];

    try {
        $db = connectDB();

        // Calculer les colonnes Victoire et Égalité
        $victoire = 0;
        $egalite = 0;

        if ($scoreEquipe > $scoreAdversaire) {
            $victoire = 1;
        } elseif ($scoreEquipe == $scoreAdversaire) {
            $egalite = 1;
        }

        // Récupérer le dernier ID inséré
        $lastIdQuery = "SELECT Id_Match FROM Matchs ORDER BY Id_Match DESC LIMIT 1";
        $lastIdStmt = $db->query($lastIdQuery);
        $lastId = $lastIdStmt->fetch(PDO::FETCH_ASSOC);

        if ($lastId) {
            // Générer le nouvel ID
            $lastIdNumber = (int) substr($lastId['Id_Match'], 1);
            $newId = 'M' . str_pad($lastIdNumber + 1, 3, '0', STR_PAD_LEFT);
        } else {
            $newId = 'M001';
        }

        // Insérer le nouveau match avec les colonnes Victoire et Égalité
        $insertQuery = "INSERT INTO Matchs (Id_Match, Date_Heure_Match, Lieu, Adversaire, Score_Equipe, Score_Adversaire, Victoire, Egalite) 
                        VALUES (:id_match, :date_heure, :lieu, :adversaire, :score_equipe, :score_adversaire, :victoire, :egalite)";
        $stmt = $db->prepare($insertQuery);
        $stmt->execute([
            ':id_match' => $newId,
            ':date_heure' => $dateHeure,
            ':lieu' => $lieu,
            ':adversaire' => $adversaire,
            ':score_equipe' => $scoreEquipe,
            ':score_adversaire' => $scoreAdversaire,
            ':victoire' => $victoire,
            ':egalite' => $egalite,
        ]);

        header('Location: ../Vue/php/Liste_Match.php?message=added');
        exit;
    } catch (PDOException $e) {
        echo "Erreur lors de l'ajout : " . $e->getMessage();
    }
}
?>
