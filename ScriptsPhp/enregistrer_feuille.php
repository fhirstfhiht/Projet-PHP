<?php
require_once '../SQL/db_Feuilles_de_Matchs.php'; // Inclusion des fonctions de gestion des données

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Initialisation
    $matchId = $_POST['Id_Match'] ?? null; // Récupérer l'identifiant du match sélectionné
    $titulairesCount = 0; // Compteur pour les titulaires

    // Vérification : Un match doit être sélectionné
    if (!$matchId) {
        die("Erreur : Aucun match sélectionné.");
    }

    try {
        // Parcourir les données envoyées via le formulaire
        foreach ($_POST as $key => $value) {
            // Identifier les clés des joueurs avec le préfixe 'joueur_'
            if (str_starts_with($key, 'joueur_') && $value === 'titulaire') {
                $numeroLicence = str_replace('joueur_', '', $key); // Extraire le numéro de licence du joueur
                insertPlayerParticipation($numeroLicence, $matchId, 'titulaire', 'Poste par défaut'); // Insertion dans la base
                $titulairesCount++;
            }
        }

        // Vérification : Au moins 5 titulaires doivent être sélectionnés
        if ($titulairesCount < 5) {
            die("Erreur : Vous devez sélectionner au moins 5 titulaires.");
        }

        // Succès
        echo "Feuille de match enregistrée avec succès.";
    } catch (Exception $e) {
        // Gestion des erreurs
        die("Erreur lors de l'enregistrement : " . $e->getMessage());
    }
} else {
    // Si la méthode n'est pas POST, afficher une erreur
    die("Méthode non autorisée.");
}
?>
