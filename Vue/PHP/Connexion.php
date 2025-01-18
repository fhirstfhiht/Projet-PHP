<!DOCTYPE HTML>

<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Connexion</title>
    <link rel="stylesheet" href="../CSS/Connexion.css">
</head>
<body class="bodyConnexion">
    <form class="login-form" action="../../Contrôleur/process_login.php" method="post">
        <h2>Connexion</h2>

        <label for="username">Identifiant :</label>
        <input type="text" id="username" name="username" placeholder="Entrez votre identifiant" required>

        <label for="password">Mot de passe :</label>
        <input type="password" id="password" name="password" placeholder="Entrez votre mot de passe" required>

        <button type="submit">Se connecter</button>
    </form>
</body>
</html>
