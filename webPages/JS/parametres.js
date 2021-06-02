// FICHIER APPLIQUANT LES PARAMETRES DE L'UTILISATEUR

function change_font(font) {
    if (font) {
        window.localStorage["articles_font"] = font;
    }
}