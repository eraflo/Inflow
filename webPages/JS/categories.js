

// Change la page poster pour la création d'une nouvelle catégorie
$(document).ready(function () {
    update_form_categories();
});
$("#categorie_selection").on('change', function(){
    update_form_categories();
});
function update_form_categories() {
    var form_categorie_selector_val = document.getElementById("categorie_selection").value;
    var form_categorie_name = document.getElementById("categorie_name");
    var form_categorie_desc = document.getElementById("categorie_desc");
    var form_categorie_img = document.getElementById("categorie_img");
    var form_categorie_img_div = document.getElementById("categorie_img_div");
    

    if (form_categorie_selector_val == "Nouvelle") {
        form_categorie_name.style.setProperty("display", "initial");
        form_categorie_desc.style.setProperty("display", "initial");
        form_categorie_img.style.setProperty("display", "initial");
        form_categorie_img_div.style.setProperty("display", "initial");
        
    } else {
        form_categorie_name.style.setProperty("display", "none");
        form_categorie_name.value = null;
        form_categorie_desc.style.setProperty("display", "none");
        form_categorie_desc.value = null;
        form_categorie_img.style.setProperty("display", "none");
        form_categorie_img.value = null;
        form_categorie_img_div.style.setProperty("display", "none");

    }
}
