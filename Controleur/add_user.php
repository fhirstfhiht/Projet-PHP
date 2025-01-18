<?php
require_once '../Modéle/db_connection.php';

// Le mot de passe que vous voulez hacher
$Password = 'admin'; // Par exemple, "admin"

// Hacher le mot de passe avec bcrypt
$hashedPassword = password_hash($Password, PASSWORD_DEFAULT);

// Créer un identifiant utilisateur unique (peut être généré selon vos besoins)
$userId = '3';  // Utilisez un ID unique pour l'utilisateur

// Préparer la requête d'insertion
$query = $pdo->prepare("INSERT INTO utilisateur (Id_Utilisateur, Login, Password) VALUES (:id, :login, :password)");
$query->execute([
    ':id' => $userId,
    ':login' => 'admin',  // Login de l'utilisateur
    ':password' => $hashedPassword
]);

echo "Utilisateur ajouté avec succès.";
?>
