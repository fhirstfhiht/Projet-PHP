<?php
session_start();
require_once 'config.php'; // Connexion à la base de données

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les données du formulaire
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Préparer et exécuter la requête pour récupérer l'utilisateur
    $query = $pdo->prepare("SELECT * FROM utilisateur WHERE Login = :username");
    $query->bindParam(':username', $username, PDO::PARAM_STR);
    $query->execute();
    $user = $query->fetch(PDO::FETCH_ASSOC);
    // Si l'utilisateur existe et que le mot de passe est correct
    if ($user && password_verify($password, $user['Password'])) {
        // Connexion réussie
        $_SESSION['user_id'] = $user['Id_Utilisateur'];  // Enregistrer l'ID de l'utilisateur dans la session
        $_SESSION['username'] = $user['Login'];  // Enregistrer le login de l'utilisateur

        // Redirection vers la page d'accueil ou le tableau de bord       
       header('Location: ../Pages/index.php');
        exit;
    } else {
        // Identifiant ou mot de passe incorrect, rediriger avec un message d'erreur
        $_SESSION['error'] = 'Identifiant ou mot de passe incorrect.';
        header('Location: ../Pages/Connexion.php');  // Rediriger vers la page de connexion
        exit;
    }
}
?>
