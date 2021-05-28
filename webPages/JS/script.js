// global vars
last_height_scroll = 0;


$(document).ready(function () {
    // ajout de la fonction 'activate_dark_mode' au bouton du darkTrigger
    $("#darkTrigger").click(dark_mode_button_on_click);
});

function dark_mode_button_on_click() {
    activate_dark_mode()
}



function activate_dark_mode() {
    // Toggle dark mode
    $("*").addClass("noTransition");
    // Changer les variables locales du client et changer l'attribut de la page
    if (window.localStorage["user-color-mode"] == "dark") {
        window.localStorage["user-color-mode"] = "light";
        document.documentElement.setAttribute("user-color-mode", "light");
    } else if ((window.localStorage["user-color-mode"] == "light") || (window.localStorage["user-color-mode"] == "hour")) {
        window.localStorage["user-color-mode"] = "dark";
        document.documentElement.setAttribute("user-color-mode", "dark");
    } else {
        window.localStorage["user-color-mode"] = "light";
        document.documentElement.setAttribute("user-color-mode", "light");
    }
    // Timeout nécessaire car le navigateur actualise les changements de "noTransition" trop rapidement
    setTimeout(function () {
        $("*").removeClass("noTransition");
    }, 30);

    smoothHeaderAppear();
}


$(document).ready(function () {
    boutonDarkMode = document.querySelector('input[type="checkbox"]');

    // On vérifie que l'attribut existe, puis on force l'application de l'attribut à la page
    if (!window.localStorage["user-color-mode"]) {
        window.localStorage["user-color-mode"] = "hour";
    } else {
        document.documentElement.setAttribute("user-color-mode", window.localStorage["user-color-mode"]);
    }
    // Si darkmode à déjà été activé par l'utilisateur alors on le garde, sinon on le change en fonction de l'heure
    if (window.localStorage["user-color-mode"] == "dark") {
        boutonDarkMode.checked = true;
    } else if (window.localStorage["user-color-mode"] == "light") {
        boutonDarkMode.checked = false;
    } else if (window.localStorage["user-color-mode"] == "hour") {
        var d = new Date();
        var h = d.getHours();
        if (h > 18 || h < 8) {
            activate_dark_mode();
            boutonDarkMode.checked = true;
        } else {
            boutonDarkMode.checked = false;
        }
    }
});


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
