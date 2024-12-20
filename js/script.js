function afficherPopupAjouterMatch() {
    const popupOverlay = document.createElement('div');
    popupOverlay.className = 'popup-overlay'; // Classe pour l'arrière-plan

    const popup = document.createElement('div');
    popup.className = 'popup'; // Classe pour le contenu

    popup.innerHTML = `
        <form action="ajouter_match.php" method="POST">
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

    popupOverlay.appendChild(popup);
    document.body.appendChild(popupOverlay);
}

function fermerPopup() {
    const popupOverlay = document.querySelector('.popup-overlay');
    if (popupOverlay) {
        popupOverlay.remove();
    }
}
