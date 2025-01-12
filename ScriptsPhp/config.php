<?php
// Configuration pour la base de données
$host = 'localhost'; // Adresse du serveur MySQL
$dbname = 'projet'; // Nom de votre base
$username = 'root'; // Par défaut, utilisateur XAMPP
$password = ''; // Par défaut, mot de passe XAMPP (vide)

// Connexion PDO
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('Erreur : ' . $e->getMessage());
}
é()