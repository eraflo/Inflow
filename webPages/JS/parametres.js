// FICHIER APPLIQUANT LES PARAMETRES DE L'UTILISATEUR

var clicks = 0;

// Utilisé en tant que  fallback en cas de desync entre le mode et le bouton
boutonDarkMode = document.getElementById("darkTrigger");
boutonPrivateMode = document.getElementById("private");

function change_font(font) {
    if (font) {
        window.localStorage["articles_font"] = font;
    }
}

function get_settings() {
    // (font, user-color-mode)
    l = window.localStorage;
    if (l["articles_font"], l["user-color-mode"], l["user-statut-mode"])
        return (l["articles_font"], l["user-color-mode"], l["user-statut-mode"]);
    return false;
}

$(document).ready(function() {
    // Synchroniser les paramètres avec les paramètres sur le serveur
    settings = get_settings();
    if (settings) {
        if (settings[0] != font && font != 0) {
            window.localStorage["articles_font"] = font;
        }
        if (settings[1] != theme && theme != 0) {
            window.localStorage["user-color-mode"] = theme;
        }
        if (settings[2] != statut && statut != 0) {
            window.localStorage["user-statut-mode"] = statut;
        }
    } else {
        if (font)
            window.localStorage["articles_font"] = font;
        if (theme)
            window.localStorage["user-color-mode"] = theme;
        if (statut)
            window.localStorage["user-statut-mode"] = statut;
    }
});


/* submit if elements of class=auto_submit_item in the form changes */
$(function() {
    $(".auto_submit_item").change(function() {
        var $form = $('#form2');
        var data = $form.serialize();
        $.ajax($form.attr('action'), { data: data, type: 'POST' }).done();
    });
});

// BOUTON PRIVTE MODEL

$(document).ready(function() {
    $("#private").click(activate_private_mode);
    if (window.localStorage["user-statut-mode"] == 1) {
        boutonPrivateMode.checked = true;
    } else if (window.localStorage["user-statut-mode"] == 0) {
        boutonPrivateMode.checked = false;
    }
})

function activate_private_mode() {
    $.ajax({
        url: "private_mode.php",
    });
}

// BOUTON DARK MODE

$(document).ready(function() {
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
        document.getElementById("SecretSelector").setAttribute('value', 'light');
    } else if ((window.localStorage["user-color-mode"] == "light") || (window.localStorage["user-color-mode"] == "hour")) {
        window.localStorage["user-color-mode"] = "dark";
        document.documentElement.setAttribute("user-color-mode", "dark");
        boutonDarkMode.checked = true;
        document.getElementById("SecretSelector").setAttribute('value', 'dark');
    } else {
        window.localStorage["user-color-mode"] = "light";
        document.documentElement.setAttribute("user-color-mode", "light");
        boutonDarkMode.checked = false;
        document.getElementById("SecretSelector").setAttribute('value', 'light');
    }
    if ((clicks >= 10) && ((clicks % 10) == 0)) {
        window.localStorage["user-color-mode"] = "rainbow";
        document.documentElement.setAttribute("user-color-mode", "rainbow");
        activate_rainbow();
        document.getElementById("SecretSelector").setAttribute('value', 'rainbow');
    } else {
        desactivate_rainbow();
    }
    // Timeout nécessaire car le navigateur actualise les changements de "noTransition" trop rapidement
    setTimeout(function() {
        $("*").removeClass("lowTransition");
    }, 1000);

    smoothHeaderAppear();
}

$(document).ready(function() {
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
    } else if (window.localStorage["user-color-mode"] == "rainbow") {
        boutonDarkMode.checked = true;
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