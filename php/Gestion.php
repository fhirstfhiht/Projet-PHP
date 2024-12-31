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
                <a href="Liste_Match.php"><button class="btn" onclick="">Liste Match</button></a>
            </section>
     </div>

    <main>
        <h1>Liste des joueurs</h1>
        <ul id="playerList">
            <?php
            require_once '../SQL/db_connection.php';
            $db = connectDB();

            // Requête pour récupérer les joueurs avec leurs informations
            $query = "SELECT j.Numero_Licence, j.Nom, j.Prenom, j.Date_De_Naissance, j.Commentaires, p.Poste, s.Libelle AS Statut 
                      FROM Joueurs j 
                      LEFT JOIN Participer p ON j.Numero_Licence = p.Numero_Licence 
                      LEFT JOIN Statut s ON j.Id_Statut = s.Id_Statut";
            $stmt = $db->query($query);

            // Parcours des résultats et affichage des joueurs
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
              // Calcul de l'âge à partir de la date de naissance
              $dateNaissance = new DateTime($row['Date_De_Naissance']);
              $today = new DateTime();
              $age = $today->diff($dateNaissance)->y;
          
              // Préparer les informations pour le pop-up
              $playerDetails = htmlspecialchars("<p>Âge : $age ans</p>") .
                               htmlspecialchars("<p>Statut : " . ($row['Statut'] ?? 'Non spécifié') . "</p>") .
                               htmlspecialchars("<p>Position : " . ($row['Poste'] ?? 'Non spécifié') . "</p>") .
                               htmlspecialchars("<p>Commentaire : " . ($row['Commentaires'] ?? 'Aucun commentaire') . "</p>") .
                               htmlspecialchars("<div class='popup-actions'>") .
                               htmlspecialchars("<button onclick=\"location.href='Modifier.php?id=" . $row['Numero_Licence'] . "'\">Modifier</button>") .
                               htmlspecialchars("<button onclick=\"location.href='Supprimer.php?id=" . $row['Numero_Licence'] . "'\">Supprimer</button>") .
                               htmlspecialchars("</div>");
          
              echo "<li class='player-item'>";
              echo "<button class='player-button' onclick=\"showPopup(`$playerDetails`)\">" . htmlspecialchars($row['Nom'] . " " . $row['Prenom']) . "</button>";
              echo "</li>";
          }
          
          
            ?>
        </ul>
    </main>

    <div id="popup" class="popup hidden">
        <div class="popup-content">
            <span id="close-popup" class="close-popup">&times;</span>
            <div id="popup-details"></div>
        </div>
    </div>

    

    <script src="../js/gestion.js"></script>
</body>

<?php include('footer.php'); ?>
</html>
