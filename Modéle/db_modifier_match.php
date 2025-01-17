<?php
// de_modifier_match.php

require_once 'db_connection.php';

function getDBConnection() {
    return connectDB();
}

/**
 * Récupérer les informations d'un match
 * @param PDO $db
 * @param int $idMatch
 * @return array|false
 */
function getMatchData(PDO $db, $idMatch) {
    $query = "SELECT * FROM Matchs WHERE Id_Match = :id";
    $stmt = $db->prepare($query);
    $stmt->execute([':id' => $idMatch]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}


function updateMatch(PDO $db, $idMatch, $dateHeure, $adversaire, $lieu, $scoreEquipe, $scoreAdversaire) {
    try {
        $updateQuery = "UPDATE Matchs 
                        SET Date_Heure_Match   = :date_heure, 
                            Lieu              = :lieu, 
                            Adversaire       = :adversaire, 
                            Score_Equipe     = :score_equipe, 
                            Score_Adversaire = :score_adversaire
                        WHERE Id_Match = :id";
        $stmt = $db->prepare($updateQuery);
        $stmt->execute([
            ':date_heure'      => $dateHeure,
            ':lieu'            => $lieu,
            ':adversaire'      => $adversaire,
            ':score_equipe'    => $scoreEquipe,
            ':score_adversaire'=> $scoreAdversaire,
            ':id'              => $idMatch
        ]);

        // Redirection après succès
        header('Location: /Projet_php/Vue/php/Liste_Match.php?message=updated');
        exit;
    } catch (PDOException $e) {
        echo "Erreur lors de la modification : " . $e->getMessage();
        exit; // Selon vos besoins, on peut stopper là ou gérer l'erreur différemment
    }
}
