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
            <!-- On inclut ici le nouveau fichier qui gère la requête et l'affichage -->
            <?php include('../../Modéle/db_Gestion.php'); ?>
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
    
    <script src="../JS/gestion.js"></script>
</body>

<?php include('footer.php'); ?>
</html>
