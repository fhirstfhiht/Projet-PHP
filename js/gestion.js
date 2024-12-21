function showPopup(playerInfo) {
    const popup = document.getElementById('popup');
    const detailsContainer = document.getElementById('popup-details');

    // Insérer les informations du joueur dans le conteneur du pop-up
    detailsContainer.innerHTML = playerInfo;

    // Activer l'affichage du pop-up
    popup.classList.add('active');
}

document.getElementById('close-popup').addEventListener('click', function() {
    const popup = document.getElementById('popup');
    popup.classList.remove('active');
});
