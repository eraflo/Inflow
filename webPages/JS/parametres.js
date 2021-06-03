// FICHIER APPLIQUANT LES PARAMETRES DE L'UTILISATEUR

function change_font(font) {
    if (font) {
        window.localStorage["articles_font"] = font;
    }
}

function get_settings() {
    // (font, user-color-mode)
    l = window.localStorage;
    return (l["articles_font"], l["user-color-mode"]);
}

$(document).ready(function () {
    // Synchroniser les paramètres avec les paramètres sur le serveur
    settings = get_settings();
    if (settings[0] != font && font != 0) {
        window.localStorage["articles_font"] = font;
    }
    if (settings[1] != theme && theme != 0) {
        window.localStorage["user-color-mode"] = theme;
    }
});
