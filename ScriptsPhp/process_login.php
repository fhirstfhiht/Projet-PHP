<?php
session_start();
require_once '../SQL/db_connection.php'; // Inclure la fonction connectDB()

// On crée l'instance PDO
$pdo = connectDB();

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
        $_SESSION['user_id'] = $user['Id_Utilisateur'];
        $_SESSION['username'] = $user['Login'];

        // Redirection vers la page d'accueil ou le tableau de bord
        header('Location: ../php/index.php');
        exit;
    } else {
        // Identifiant ou mot de passe incorrect
        $_SESSION['error'] = 'Identifiant ou mot de passe incorrect.';
        header('Location: ../php/Connexion.php');
        exit;
    }
}
?>
