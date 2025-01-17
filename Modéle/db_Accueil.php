<?php
require_once 'db_connection.php';

try {
    $db = connectDB();

    // Initialisation des variables
    $message = null;
    $nextMatch = null;

    // Requête pour récupérer le prochain match
    $query = "SELECT * FROM Matchs WHERE Date_Heure_Match > NOW() ORDER BY Date_Heure_Match ASC LIMIT 1";
    $stmt = $db->query($query);
    $nextMatch = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$nextMatch) {
        $message = "Aucun match à venir.";
    }
} catch (PDOException $e) {
    $message = "Erreur lors de la récupération du match : " . $e->getMessage();
}
?>
