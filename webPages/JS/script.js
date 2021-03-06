// global vars
last_height_scroll = 0;



// Actualisation des articles (#actualisation_publication ET actualisation_publication.php)
setInterval('actualisation_publication()', 15000); // 15s
function actualisation_publication() {
    $('#actualisation_publication').load('actualisation_publication.php'+$(location).attr('search'));
}

function accept_cookie() {
    $.ajax({
        type: 'GET',
        url: "accept_cookie.php",
        success: function(data) {
            $(".cookie-alert").css("display", "none");
        }
    });
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


// Script permettant de ne pas afficher certains éléments du footer sur certaines pages
$(document).ready(function () {
    var actual_page_address = $(location).attr('pathname').split("/").pop();
    var actual_page_name = actual_page_address.split(".")[0].toUpperCase();
    var pages_minimal_footer = ["parametres", "inscription", "connexion"].map(page => page.toUpperCase());
    if ($.inArray(actual_page_name, pages_minimal_footer) != -1) {
        $("footer .footer_Contact").css("display", "none");
        $("footer .footer_Equipe").css("display", "none");
    }
    
});

