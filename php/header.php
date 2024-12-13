<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="fr">
    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="../css/Base.css">
<body>
    <header>
            <div class="menu-container">
                <div class="logo">
                    <a href="../php/Acceuil.php"><img src="../img/basketball2.jpg" alt="logo"></a>
                </div>
                <div class="burger-menu" onclick="toggleMenu()">
                    <div class="bar"></div>
                    <div class="bar"></div>
                    <div class="bar"></div>
                </div>
                <ul class="menuheader">
                    <li><a href="/PHP/feuille_de_match.php">Feuille de Match</a></li>
                    <li><a href="/PHP/match.php">Match</a></li>
                    <li><a href="/PHP/.php">Rien</a></li>
                    <li><a href="/PHP/stats.php">Statistiques</a></li>
                    <li><a href="#" class="display-picture"><img src="" alt="profil"></a></li>
                </ul>
            </div>
            
            
    </header>
</body>
</html>