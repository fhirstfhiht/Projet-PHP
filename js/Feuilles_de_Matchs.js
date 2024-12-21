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