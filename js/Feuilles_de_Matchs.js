function confirmerValidation(event) {
    event.preventDefault();

    // Compter le nombre de titulaires sélectionnés
    const titulaires = document.querySelectorAll("input[type='radio'][value='titulaire']:checked").length;

    if (titulaires < 5) {
        alert("Vous devez sélectionner au moins 5 titulaires avant d'enregistrer.");
        return;
    }

    if (confirm("Êtes-vous sûr de vouloir enregistrer cette feuille de match ?")) {
        document.getElementById("feuilleDeMatchForm").submit();
    }
    
}

document.getElementById("feuilleDeMatchForm").addEventListener("submit", function (event) {
    // Vérifiez qu'au moins 5 titulaires sont sélectionnés
    const titulaires = document.querySelectorAll("input[type='radio'][value='titulaire']:checked").length;

    if (titulaires < 5) {
        alert("Vous devez sélectionner au moins 5 titulaires avant d'enregistrer.");
        event.preventDefault(); // Empêche la soumission du formulaire
        return;
    }

    // Vérifiez qu'un match est sélectionné
    const matchSelect = document.getElementById("match");
    if (!matchSelect.value) {
        alert("Veuillez sélectionner un match avant de soumettre le formulaire.");
        event.preventDefault();
    }
});

