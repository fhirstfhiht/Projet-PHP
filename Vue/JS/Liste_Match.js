function afficherPopupAjouterMatch() {
    const popupOverlay = document.getElementById('popupAjouterMatch');
    if (popupOverlay) {
        popupOverlay.style.display = 'block';
    } else {
        const overlay = document.createElement('div');
        overlay.id = 'popupAjouterMatch';
        overlay.className = 'popup-overlay';

        const popup = document.createElement('div');
        popup.className = 'popup';
        popup.innerHTML = `
            <form action="/Projet_php/Contrôleur/ajouter_match.php" method="POST">
                <h2>Ajouter un Match</h2>
                <label for="date_heure">Date et Heure :</label>
                <input type="datetime-local" name="date_heure" id="date_heure" required>

                <label for="adversaire">Adversaire :</label>
                <input type="text" name="adversaire" id="adversaire" required>

                <label for="lieu">Lieu :</label>
                <input type="text" name="lieu" id="lieu" required>

                <label for="score_equipe">Score Équipe :</label>
                <input type="number" name="score_equipe" id="score_equipe" min="0" value="0" required>

                <label for="score_adversaire">Score Adversaire :</label>
                <input type="number" name="score_adversaire" id="score_adversaire" min="0" value="0" required>

                <button type="submit">Ajouter</button>
                <button type="button" onclick="fermerPopup()">Annuler</button>
            </form>
        `;

        overlay.appendChild(popup);
        document.body.appendChild(overlay);
    }
}

// Ferme la fenêtre modale
function fermerPopup() {
    const popupOverlay = document.getElementById('popupAjouterMatch');
    if (popupOverlay) {
        popupOverlay.style.display = 'none';
    }
}

// Confirme la suppression d'un match
function confirmerSuppression(idMatch) {
    if (confirm("Êtes-vous sûr de vouloir supprimer ce match ?")) {
        window.location.href = `../../Contrôleur/supprimer_match.php?id=${idMatch}`;
    }
}
