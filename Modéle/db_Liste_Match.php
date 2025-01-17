<?php
require_once 'db_connection.php';

$db = connectDB();

$query = "SELECT Id_Match, Date_Heure_Match, Adversaire, Lieu, Score_equipe, Score_adversaire FROM Matchs";
$stmt = $db->query($query);

$currentDateTime = new DateTime();

// Parcours des résultats et affichage de chaque ligne
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    echo "<tr>";
    echo "<td>" . htmlspecialchars($row['Date_Heure_Match']) . "</td>";
    echo "<td>" . htmlspecialchars($row['Adversaire']) . "</td>";
    echo "<td>" . htmlspecialchars($row['Lieu']) . "</td>";

    $matchDateTime = new DateTime($row['Date_Heure_Match']);
    if ($matchDateTime > $currentDateTime) {
        // Match à venir
        echo "<td>A définir</td>";
    } else {
        // Match passé => Affichage du résultat
        if (!is_null($row['Score_equipe']) && !is_null($row['Score_adversaire'])) {
            if ($row['Score_equipe'] > $row['Score_adversaire']) {
                $result = 'Victoire';
            } elseif ($row['Score_equipe'] === $row['Score_adversaire']) {
                $result = 'Égalité';
            } else {
                $result = 'Défaite';
            }
        } else {
            $result = 'Non défini';
        }
        echo "<td>" . htmlspecialchars($result) . "</td>";
    }

    // Actions de modification / suppression
    echo "<td>";
    // On n'affiche "Modifier" que si le match est futur
    if ($matchDateTime > $currentDateTime) {
        echo "<a href='/Projet_php/Contrôleur/modifier_match.php?id=" . htmlspecialchars($row['Id_Match']) . "'>Modifier</a> | ";
    }
    echo "<a href='javascript:void(0)' onclick=\"confirmerSuppression('" . htmlspecialchars($row['Id_Match']) . "')\">Supprimer</a>";
    echo "</td>";

    echo "</tr>";
}
