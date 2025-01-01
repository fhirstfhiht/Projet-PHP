// Affiche la fenêtre modale pour ajouter un match
function afficherPopupAjouterMatch() {
    const popupOverlay = document.getElementById('popupAjouterMatch');
    if (popupOverlay) {
        popupOverlay.style.display = 'block';
    } else {
        // Création dynamique si la modale n'existe pas dans le DOM
        const overlay = document.createElement('div');
        overlay.id = 'popupAjouterMatch';
        overlay.className = 'popup-overlay';

        const popup = document.createElement('div');
        popup.className = 'popup';
        popup.innerHTML = `
            <form action="../ScriptsPhp/ajouter_match.php" method="POST">
                <h2>Ajouter un Match</h2>
                <label for="date_heure">Date et Heure :</label>
                <input type="datetime-local" name="date_heure" id="date_heure" required>

                <label for="adversaire">Adversaire :</label>
                <input type="text" name="adversaire" id="adversaire" required>

                <label for="lieu">Lieu :</label>
                <select name="lieu" id="lieu" required>
                    <option value="domicile">Domicile</option>
                    <option value="extérieur">Extérieur</option>
                </select>

                <label for="lieu_precis">Lieu Précis :</label>
                <input type="text" name="lieu_precis" id="lieu_precis" required>

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
        window.location.href = `../ScriptsPhp/supprimer_match.php?id=${idMatch}`;
    }
}
