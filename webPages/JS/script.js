// global vars
last_height_scroll = 0;



// Actualisation des articles (#actualisation_publication ET actualisation_publication.php)
setInterval('actualisation_publication()', 15000); // 15s
function actualisation_publication() {
    $('#actualisation_publication').load('actualisation_publication.php');
}


function activate_rainbow() {
    // change la couleur des éléments en permanence (rainbow) au cours du temps
    $(".can_rainbow").each(function (index) {
        $(this).addClass("rainbow");
    });
    $(".can_rainbow2").each(function (index) {
        $(this).addClass("rainbow2");
    });
}
function desactivate_rainbow() {
    $(".can_rainbow").each(function (index) {
        $(this).removeClass("rainbow");
    });
    $(".can_rainbow2").each(function (index) {
        $(this).removeClass("rainbow2");
    });
}


// Affiche les éléments du header petit à petit
$(document).ready(function () {
    smoothHeaderAppear();
});
function smoothHeaderAppear() {
    if ($( window ).width() > 800) {
        $(".headerFirstElement").each(function (index) {
            $(this).finish();
            $(this).fadeOut(0);
        });
        $(".headerFirstElement").each(function (index) {
            $(this).delay(100 * index).fadeIn(1000);
        });
    }
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
    user_color_mode = window.localStorage["user-color-mode"];
    if (user_color_mode) {
        document.documentElement.setAttribute("user-color-mode", user_color_mode);
    }
    if (user_color_mode == "rainbow") {
        activate_rainbow();
    }
}
