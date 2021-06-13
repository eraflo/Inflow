// FICHIER APPLIQUANT LES PARAMETRES DE L'UTILISATEUR

var clicks = 0;

// Utilisé en tant que  fallback en cas de desync entre le mode et le bouton
boutonDarkMode = document.getElementById("darkTrigger");


function change_font(font) {
    if (font) {
        window.localStorage["articles_font"] = font;
    }
}

function get_settings() {
    // (font, user-color-mode)
    l = window.localStorage;
    if (l["articles_font"], l["user-color-mode"])
        return (l["articles_font"], l["user-color-mode"]);
    return false;
}

$(document).ready(function () {
    // Synchroniser les paramètres avec les paramètres sur le serveur
    settings = get_settings();
    if (settings) {
        if (settings[0] != font && font != 0) {
            window.localStorage["articles_font"] = font;
        }
        if (settings[1] != theme && theme != 0) {
            window.localStorage["user-color-mode"] = theme;
        }
    } else {
        if (font)
            window.localStorage["articles_font"] = font;
        if (theme)
            window.localStorage["user-color-mode"] = theme;
    }
});


// BOUTON DARK MODE

$(document).ready(function () {
    // ajout de la fonction 'activate_dark_mode' au bouton du darkTrigger
    $("#darkTrigger").click(activate_dark_mode);
});

function activate_dark_mode() {
    clicks++;

    // Toggle dark mode
    $("*").addClass("lowTransition");
    // Exceptions
    $(".headerFirstElement").removeClass("lowTransition");

    // Changer les variables locales du client et changer l'attribut de la page
    if (window.localStorage["user-color-mode"] == "dark") {
        window.localStorage["user-color-mode"] = "light";
        document.documentElement.setAttribute("user-color-mode", "light");
        boutonDarkMode.checked = false;
        $("#SecretSelector").value = "light";
    } else if ((window.localStorage["user-color-mode"] == "light") || (window.localStorage["user-color-mode"] == "hour")) {
        window.localStorage["user-color-mode"] = "dark";
        document.documentElement.setAttribute("user-color-mode", "dark");
        boutonDarkMode.checked = true;
        $("#SecretSelector").value = "dark";
    } else {
        window.localStorage["user-color-mode"] = "light";
        document.documentElement.setAttribute("user-color-mode", "light");
        boutonDarkMode.checked = false;
        $("#SecretSelector").value = "light";
    }
    if ((clicks >= 10) && ((clicks % 10) == 0)) {
        window.localStorage["user-color-mode"] = "rainbow";
        document.documentElement.setAttribute("user-color-mode", "rainbow");
        activate_rainbow();
        $("#SecretSelector").value = "rainbow";
    } else {
        desactivate_rainbow();
    }
    // Timeout nécessaire car le navigateur actualise les changements de "noTransition" trop rapidement
    setTimeout(function () {
        $("*").removeClass("lowTransition");
    }, 1000);

    smoothHeaderAppear();
}

$(document).ready(function () {
    boutonDarkMode = document.getElementById("darkTrigger");

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
            document.documentElement.setAttribute("user-color-mode", "dark");
            boutonDarkMode.checked = true;
        } else {
            boutonDarkMode.checked = false;
        }
    }
});