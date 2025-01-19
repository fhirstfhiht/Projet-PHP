
<?php

require_once 'db_connection.php';

function getJoueursActifs($pdo) {
    $query = "SELECT Numero_Licence, Nom, Prenom, Poste_Joueur FROM joueurs WHERE Id_Statut = 'STAT001'";
    $stmt = $pdo->query($query);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getMatchsavenir($pdo) {
    $query = "SELECT Id_Match, Date_Heure_Match, Adversaire FROM matchs WHERE Date_Heure_Match > NOW()";
    $stmt = $pdo->query($query);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getAllMatches($pdo) {
    $query = $pdo->query("SELECT Id_Match, Date_Heure_Match, Adversaire FROM matchs");
    return $query->fetchAll(PDO::FETCH_ASSOC);
}

function getPlayersForMatch($pdo, $matchId) {
    $query = $pdo->prepare("
        SELECT 
            p.Numero_Licence,
            j.Nom,
            j.Prenom,
            p.Poste_Match AS Poste,
            p.Statut_Participation,
            p.Note,
            j.Commentaires
        FROM participer p
        JOIN joueurs j ON p.Numero_Licence = j.Numero_Licence
        WHERE p.Id_Match = :match_id
    ");
    $query->execute(['match_id' => $matchId]);
    return $query->fetchAll(PDO::FETCH_ASSOC);
}
?>