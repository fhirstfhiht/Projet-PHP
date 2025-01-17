<?php
// de_modifier.php

include_once 'db_connection.php'; // Inclusion de la connexion

function getDBConnection() {
    return connectDB();
}

/**
 * Récupérer les informations d'un joueur via son Numero_Licence.
 * @param PDO    $pdo
 * @param string $licenceId
 * @return array|false
 */
function getJoueurById(PDO $pdo, string $licenceId) {
    $query = $pdo->prepare("SELECT * FROM joueurs WHERE Numero_Licence = :id");
    $query->bindParam(':id', $licenceId, PDO::PARAM_STR);
    $query->execute();
    return $query->fetch(PDO::FETCH_ASSOC);
}

/**
 * Mettre à jour les informations du joueur, y compris les commentaires.
 * @param PDO    $pdo
 * @param string $licenceId
 * @param array  $joueurData
 */
function updateJoueur(PDO $pdo, string $licenceId, array $joueurData) {
    $updateQuery = $pdo->prepare(
        "UPDATE joueurs 
         SET Nom               = :nom, 
             Prenom            = :prenom, 
             Date_De_Naissance = :date_naissance, 
             Taille            = :taille, 
             Poids             = :poids, 
             Poste_Joueur      = :poste, 
             Id_Statut         = :id_statut,
             Commentaires      = :commentaires
         WHERE Numero_Licence  = :id"
    );

    $updateQuery->execute([
        ':nom'          => $joueurData['nom'],
        ':prenom'       => $joueurData['prenom'],
        ':date_naissance'=> $joueurData['date_naissance'],
        ':taille'       => $joueurData['taille'],
        ':poids'        => $joueurData['poids'],
        ':poste'        => $joueurData['poste'],
        ':id_statut'    => $joueurData['Id_Statut'],
        ':commentaires' => $joueurData['commentaires'] ?? '', 
        ':id'           => $licenceId,
    ]);
}
