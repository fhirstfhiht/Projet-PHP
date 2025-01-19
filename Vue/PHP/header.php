<!DOCTYPE HTML>
<html lang="fr">
<link rel="stylesheet" href="../CSS/header.css">
    <head>
		<link rel="icon" type="image/x-icon" href="../Images/icon.ico">
    </head>

<header>
    <!-- Logo avec lien vers la page d'accueil -->
    <a href="Acceuil.php">
        <img src="../Images/logo.png" alt="Logo" />
    </a>

    <div class="menu-container">
        <nav>
            <ul>
                <!-- Accueil -->
                <li>
                    <a href="Acceuil.php" 
                       class="<?= basename($_SERVER['PHP_SELF']) == 'Acceuil.php' ? 'active' : '' ?>">
                       Accueil
                    </a>
                </li>

                <!-- GESTION + Sous-menu -->
                <li class="dropdown">
                    <!-- Le lien parent “Gestion” -->
                    <a href="Gestion.php"
                       class="<?=
                           ( basename($_SERVER['PHP_SELF']) == 'Gestion.php'
                             || basename($_SERVER['PHP_SELF']) == 'Liste_Match.php')
                             ? 'active'
                             : ''
                       ?>">
                        Gestion
                    </a>
                    <!-- Sous-menu -->
                    <ul class="dropdown-menu">
                        <li><a href="Gestion.php">Liste Joueur</a></li>
                        <li><a href="Liste_Match.php">Liste Match</a></li>
                    </ul>
                </li>

                <!-- FEUILLE DE MATCH + Sous-menu -->
                <li class="dropdown">
                    <!-- Le lien parent “Feuille de Match” -->
                    <a href="Feuilles_de_Matchs.php"
                       class="<?=
                           ( basename($_SERVER['PHP_SELF']) == 'Feuilles_de_Matchs.php'
                             || basename($_SERVER['PHP_SELF']) == 'modifier_feuille_de_match.php')
                             ? 'active'
                             : ''
                       ?>">
                        Feuille de Match
                    </a>
                    <!-- Sous-menu -->
                    <ul class="dropdown-menu">
                        <li><a href="Feuilles_de_Matchs.php">Enregistrer Feuille de Match</a></li>
                        <li><a href="modifier_feuille_de_match.php">Modification Feuille de Match</a></li>
                    </ul>
                </li>

                <!-- STATISTIQUES -->
                <li>
                    <a href="Statistique.php" 
                       class="<?= basename($_SERVER['PHP_SELF']) == 'Statistique.php' ? 'active' : '' ?>">
                       Statistiques
                    </a>
                </li>
            </ul>
        </nav>
    </div>

    <!-- Lien de déconnexion -->
    <a href="Connexion.php" class="connexion">Déconnexion</a>
</header>
</html>
