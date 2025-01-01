console.log("Fichier gestion.js chargé !");


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

document.addEventListener('DOMContentLoaded', function() {
    // Gestion déléguée pour le bouton Modifier
    document.body.addEventListener('click', function(event) {
        if (event.target.classList.contains('btn-modifier')) {
            console.log("Bouton Modifier cliqué");
            const joueurId = event.target.getAttribute('data-id');
            window.location.href = `../ScriptsPhp/modifier.php?id=${joueurId}`;
        }
    });    
});

document.addEventListener('DOMContentLoaded', function () {
    console.log("DOM chargé et gestion.js actif !");

    // Gestion des clics sur le body
    document.body.addEventListener('click', function (event) {
        console.log("Élément cliqué :", event.target);

        // Vérifiez si le clic provient d'un bouton Supprimer
        if (event.target.classList.contains('btn-supprimer')) {
            console.log("Bouton Supprimer détecté !");
            const joueurId = event.target.getAttribute('data-id');
            console.log("ID du joueur à supprimer :", joueurId);

            if (confirm('Êtes-vous sûr de vouloir supprimer ce joueur ?')) {
                fetch(`../ScriptsPhp/supprimer.php?id=${joueurId}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert('Joueur supprimé avec succès.');
                            window.location.reload();
                        } else {
                            alert(`Erreur : ${data.error}`);
                        }
                    })
                    .catch(error => console.error('Erreur réseau :', error));
            }
        }
    });
});


