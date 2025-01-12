document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("feuilleDeMatchForm");

    if (!form) {
        console.error("Le formulaire avec l'ID 'feuilleDeMatchForm' est introuvable.");
        return;
    }

    form.addEventListener("submit", function (event) {
        // Vérifiez qu'un match est sélectionné
        const matchSelect = document.getElementById("match");
        if (!matchSelect || !matchSelect.value) {
            alert("Veuillez sélectionner un match avant de soumettre le formulaire.");
            event.preventDefault();
            return;
        }

        // Vérifiez qu'au moins 5 joueurs sont marqués comme titulaires
        const titulaires = document.querySelectorAll("input[type='radio'][value='titulaire']:checked").length;
        if (titulaires < 5) {
            alert("Vous devez sélectionner au moins 5 titulaires avant d'enregistrer.");
            event.preventDefault();
            return;
        }

        // Validez uniquement les joueurs sélectionnés (titulaire ou remplaçant)
        const joueurs = document.querySelectorAll("tr");
        let validationOk = true;

        joueurs.forEach((joueur) => {
            const posteSelect = joueur.querySelector("select[name*='[poste]']");
            const statutRadio = joueur.querySelector("input[type='radio']:checked");

            // Si le joueur a un statut sélectionné, vérifiez son poste
            if (statutRadio) {
                if (!posteSelect || !posteSelect.value) {
                    validationOk = false;
                    alert("Veuillez sélectionner un poste pour tous les joueurs marqués comme titulaire ou remplaçant.");
                    return;
                }
            }
        });

        if (!validationOk) {
            event.preventDefault();
            return;
        }

        // Confirmation avant soumission
        if (!confirm("Êtes-vous sûr de vouloir enregistrer cette feuille de match ?")) {
            event.preventDefault();
        }
    });
});
