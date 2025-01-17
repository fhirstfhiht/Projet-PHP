function showPopup(playerInfo) {
    const popup = document.getElementById('popup');
    const detailsContainer = document.getElementById('popup-details');

    detailsContainer.innerHTML = playerInfo;

    popup.classList.add('active');
}

document.getElementById('close-popup').addEventListener('click', function() {
    const popup = document.getElementById('popup');
    popup.classList.remove('active');
});

document.addEventListener('DOMContentLoaded', function() {
    document.body.addEventListener('click', function(event) {
        if (event.target.classList.contains('btn-modifier')) {
            console.log("Bouton Modifier cliqué");
            const joueurId = event.target.getAttribute('data-id');
            window.location.href = `../../Contrôleur/modifier.php?id=${joueurId}`;
        }
    });

    document.body.addEventListener('click', function(event) {
        console.log("Élément cliqué :", event.target);

        if (event.target.classList.contains('btn-supprimer')) {
            const joueurId = event.target.getAttribute('data-id');
            console.log("ID du joueur à supprimer :", joueurId);

            if (confirm('Êtes-vous sûr de vouloir supprimer ce joueur ?')) {
                fetch(`../../Contrôleur/supprimer.php?id=${joueurId}`)
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

function afficherPopupAjouterJoueur() {
    console.log("Bouton Ajouter un Joueur cliqué.");
    let popupContent = document.getElementById("popupContent");

    if (!popupContent) {
        console.log("popupContent n'existe pas, création dynamique.");
        const overlay = document.getElementById("popupAjouterJoueurOverlay");
        popupContent = document.createElement("div");
        popupContent.id = "popupContent";
        popupContent.className = "popup-ajouter-joueur";
        popupContent.style.display = "none"; 
        overlay.appendChild(popupContent); 
    }

    popupContent.style.display = "block"; 
    popupContent.innerHTML = `
        <form action="../../Contrôleur/ajouter_Joueur.php" method="POST" onsubmit="return validerFormulaire()">
            <h2>Ajouter un Joueur</h2>
            
            <label for="nom">Nom :</label>
            <input type="text" name="nom" id="nom" required>

            <label for="prenom">Prénom :</label>
            <input type="text" name="prenom" id="prenom" required>

            <label for="date_naissance">Date de Naissance :</label>
            <input type="date" name="date_naissance" id="date_naissance" required>


            <label for="Numero_Licence">n° Licence :</label>
            <input type="text" name="Numero_Licence" id="Numero_Licence" required placeholder="Doit commencer par J">

            <label for="taille">Taille (cm) :</label>
            <input type="number" name="taille" id="taille" required placeholder="Exemple : 180">

            <label for="poids">Poids (kg) :</label>
            <input type="number" name="poids" id="poids" required placeholder="Exemple : 75">

            <label for="statut">Statut :</label>
            <select name="Id_Statut" id="statut" required>
                <option value="STAT001">Actif</option>
                <option value="STAT002">Blessé</option>
                <option value="STAT003">Suspendu</option>
                <option value="STAT004">Absent</option>
            </select>


            <label for="poste">Poste :</label>
            <select name="Poste" id="poste" required>
                <option value="Ailier">Ailier</option>
                <option value="Meneur">Meneur</option>
                <option value="Arrière">Arrière</option>
                <option value="Ailier Fort">Ailier Fort</option>
                <option value="Pivot">Pivot</option>
            </select>


            <button type="submit">Ajouter</button>
            <button type="button" onclick="fermerPopupAjouterJoueur()">Annuler</button>
        </form>
    `;
}

function validerFormulaire() {
    const Numero_Licence = document.getElementById("Numero_Licence").value;
    if (!Numero_Licence.startsWith("J")) {
        alert("Le numéro de licence doit commencer par 'J'.");
        return false; 
    }

    if (!poste) {
        alert("Veuillez sélectionner un poste.");
        return false;
    }
    
    return true; 
}

function fermerPopupAjouterJoueur() {
    console.log("Fermeture du popup Ajouter un Joueur.");
    const popupContent = document.getElementById('popupContent');
    if (popupContent) {
        popupContent.style.display = 'none'; 
        popupContent.innerHTML = ''; 
    } else {
        console.error('Le popupContent est introuvable.');
    }
}


document.addEventListener("DOMContentLoaded", function () {
    const popupContent = document.getElementById("popupContent");
    if (popupContent) {
        console.log("popupContent trouvé :", popupContent);
    } else {
        console.error("popupContent n'est pas présent dans le DOM après le chargement.");
    }
});

