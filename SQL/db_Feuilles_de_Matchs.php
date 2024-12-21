
<?php

require_once '../SQL/db_connection.php';

function getMatchsavenir($db) {
    $query = "SELECT Id_Match, Date_Heure_Match, Adversaire FROM Matchs WHERE Date_Heure_Match > NOW()";
    $stmt = $db->query($query);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getJoueursactifsavecposition($db) {
    $query = "SELECT j.Numero_Licence, j.Nom, j.Prenom, j.Taille, j.Poids, j.Commentaires, p.Poste 
              FROM Joueurs j 
              LEFT JOIN Participer p ON j.Numero_Licence = p.Numero_Licence 
              WHERE j.Id_Statut = 'STAT001'";
    $stmt = $db->query($query);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
