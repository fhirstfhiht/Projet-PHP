<!DOCTYPE HTML>
<html lang="fr">
    <link rel="stylesheet" href="../css/header.css">
    <header>
        <!-- Logo avec lien vers ma page d'acceil -->
        <a href="index.php">
            <img src="../img/logo.png" />
        </a>
        <div class="menu-container">
            <nav>
                <ul>
                    <li><a href="index.php" class="<?= basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : '' ?>">Accueil</a></li>
                    <li><a href="Gestion.php" class="<?= basename($_SERVER['PHP_SELF']) == 'Gestion.php' ? 'active' : '' ?>">Gestion</a></li>
                    <li><a href="Feuilles_de_Matchs.php" class="<?= basename($_SERVER['PHP_SELF']) == 'FeuilleMatch.php' ? 'active' : '' ?>">Feuille de Match</a></li>
                    <li><a href="Statistique.php" class="<?= basename($_SERVER['PHP_SELF']) == 'Statistique.php' ? 'active' : '' ?>">Statistique</a></li>
                </ul>
            </nav>
        </div>
        <a href="Connexion.php" class="connexion">Deconnexion</a>
    </header>
</html>