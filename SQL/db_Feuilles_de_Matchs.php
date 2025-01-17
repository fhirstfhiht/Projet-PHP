
<?php

require_once '../SQL/db_connection.php';

function getMatchsavenir($pdo) {
    $query = "SELECT Id_Match, Date_Heure_Match, Adversaire FROM matchs WHERE Date_Heure_Match > NOW()";
    $stmt = $pdo->query($query);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getJoueursActifs($pdo) {
    $query = "SELECT Numero_Licence, Nom, Prenom, Poste_Joueur FROM joueurs WHERE Id_Statut = 'STAT001'";
    $stmt = $pdo->query($query);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>
