// global vars
last_height_scroll = 0;



// Script pour customiser éditeur de texte pour articles
$(function() { var Options = {
        buttons: "bold,italic,underline,strike,|,sup,sub,|,img,video,link,|,bullist,numlist,|,\fontcolor,\
        fontsize,fontfamily,|,justifyleft,justifycenter,justifyright,|,quote,code,table,removeFormat",
        lang: "fr" }
    $("#editor").wysibb(Options); 
})


// Script pour la barre de recherche
$(document).ready(function() {
    $('#search').keyup(function() {
        $('#result-research').html('');
        var research = $(this).val();

        if(research != "") {
            $.ajax({
                type: 'GET',
                url: "recherche.php",
                data: 'user=' + encodeURIComponent(research),
                success: function(data) {
                    if(data != "") {
                        $('#result-research').append(data);
                    } else {
                        document.getElementById('result-research').innerHTML = "<div>Aucune correspondance</div>"
                    }
                }
            });
        }
    });
});

// Actualisation des articles (#actualisation ET actualisation_page.php À CHANGER DE NOM IMPÉRATIVEMENT)
setInterval('load_page()', 10000);
function load_page() {
    $('#actualisation').load('actualisation_page.php');
}



// Affiche les éléments du header petit à petit
$(document).ready(function () {
    smoothHeaderAppear();
});
function smoothHeaderAppear() {
    $(".headerFirstElement").each(function (index) {
        $(this).finish();
        $(this).fadeOut(0);
    });
    $(".headerFirstElement").each(function (index) {
        $(this).delay(100 * index).fadeIn(1000);
    });
}


// Change la taille de la banniere fixe lors du scroll down/up

window.onscroll = function () {
    scrollFunction()
};
function scrollFunction() {
    banniere = document.getElementsByClassName("banniere")[0];
    actual_scroll = document.documentElement.scrollTop
    check_position = (Math.abs(actual_scroll - last_height_scroll) > 80);
    if (!check_position)
        return;

    if (actual_scroll > 2000) {
        banniere.style.height = "0px";
        banniere.style.opacity = "0%";
        last_height_scroll = actual_scroll;
    } else if (actual_scroll > 500) {
        banniere.style.height = "70px";
        banniere.style.opacity = "100%";
        last_height_scroll = actual_scroll;
    } else {
        banniere.style.height = "130px";
        banniere.style.opacity = "100%";
        last_height_scroll = actual_scroll;
    }
}


// Applique les paramètres personnalisés à la page
$(document).ready(function () {
    apply_settings();
});
function apply_settings() {
    articles_font = window.localStorage["articles_font"];
    if (articles_font) {
        document.documentElement.style.setProperty('--font-article', articles_font);
    }
}