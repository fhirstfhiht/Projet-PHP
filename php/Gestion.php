<!DOCTYPE HTML>
<html lang="fr">
<head>
    <meta charset="utf-8" />
    <title>Gestion</title>
    <link rel="stylesheet" href="../css/Gestion.css">
    <link rel="stylesheet" href="../css/base.css">
    <link rel="stylesheet" href="../css/index.css">
</head>
<?php include('header.php'); ?>

<body>
    <div class="centrer">
        <section>
            <a href="Liste_Match.php"><button class="btn">Liste Match</button></a>
        </section>
    </div>

    <main>
        <h1>Liste des joueurs</h1>
        <ul id="playerList">
            <?php
            require_once '../SQL/db_connection.php';
            $db = connectDB();

            // Requête pour récupérer les joueurs avec leurs informations
            $query = "SELECT j.Numero_Licence, j.Nom, j.Prenom, j.Date_De_Naissance, j.Commentaires, 
                             j.Poste_Joueur AS Poste, 
                             s.Libelle AS Statut 
                      FROM Joueurs j 
                      LEFT JOIN Statut s ON j.Id_Statut = s.Id_Statut";
            $stmt = $db->query($query);

            // Parcours des résultats et affichage des joueurs
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                // Calcul de l'âge à partir de la date de naissance
                $dateNaissance = new DateTime($row['Date_De_Naissance']);
                $today = new DateTime();
                $age = $today->diff($dateNaissance)->y;

                // Préparer les informations pour le pop-up
                $playerDetails = "
                    <p>Âge : $age ans</p>
                    <p>Statut : " . htmlspecialchars($row['Statut'] ?? 'Non spécifié') . "</p>
                    <p>Position : " . htmlspecialchars($row['Poste']) . "</p>
                    <p>Commentaire : " . htmlspecialchars($row['Commentaires'] ?? 'Aucun commentaire') . "</p>
                    <div class='popup-actions'>
                        <button class='btn-modifier' data-id='" . htmlspecialchars($row['Numero_Licence']) . "'>Modifier</button>
                        <button class='btn-supprimer' data-id='" . htmlspecialchars($row['Numero_Licence']) . "'>Supprimer</button>
                    </div>";

                // Affichage dans la liste
                echo "<li class='player-item'>";
                echo "<button class='player-button' onclick=\"showPopup(`" . htmlspecialchars($playerDetails, ENT_QUOTES) . "`)\">" . htmlspecialchars($row['Nom'] . " " . $row['Prenom']) . "</button>";
                echo "</li>";
            }
            ?>
        </ul>
    </main>

    <!-- Pop-up pour afficher les détails -->
    <div id="popup" class="popup hidden">
        <div class="popup-content">
            <span id="close-popup" class="close-popup">&times;</span>
            <div id="popup-details"></div>
        </div>
    </div>

    <div id="popupAjouterJoueurOverlay" class="centrer">
        <button class="btn" onclick="afficherPopupAjouterJoueur()">Ajouter un Joueur</button>
    </div>
    
    <script src="../js/gestion.js"></script>
</body>

<?php include('footer.php'); ?>
</html>
