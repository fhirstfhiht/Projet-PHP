// Fonction pour afficher une pop-up pour "Ajouter un Match"
function afficherPopupAjouterMatch() {
    const popup = document.createElement('div');
    popup.innerHTML = `
        <div class="popup">
            <form action="ajouter_match.php" method="POST">
                <h2>Ajouter un Match</h2>
                <label for="date_heure">Date et Heure :</label>
                <input type="datetime-local" name="date_heure" id="date_heure" required><br>

                <label for="adversaire">Adversaire :</label>
                <input type="text" name="adversaire" id="adversaire" required><br>

                <label for="lieu">Lieu :</label>
                <select name="lieu" id="lieu" required>
                    <option value="domicile">Domicile</option>
                    <option value="extérieur">Extérieur</option>
                </select><br>

                <label for="lieu_precis">Lieu précis :</label>
                <input type="text" name="lieu_precis" id="lieu_precis" required><br>

                <button type="submit">Ajouter</button>
                <button type="button" onclick="fermerPopup()">Annuler</button>
            </form>
        </div>
    `;
    document.body.appendChild(popup);
}

// Fonction pour fermer la pop-up
function fermerPopup() {
    const popup = document.querySelector('.popup');
    if (popup) {
        popup.remove();
    }
}

// Fonction pour confirmer la suppression d'un match
function confirmerSuppression(event, url) {
    event.preventDefault();
    if (confirm("Êtes-vous sûr de vouloir supprimer ce match ?")) {
        window.location.href = url;
    }
}
