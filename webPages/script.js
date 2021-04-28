$(document).ready(function () {
    // ajout de la fonction 'activate_dark_mode' au bouton du darkTrigger
    $("#darkTrigger").click(dark_mode_button_on_click);
})

function dark_mode_button_on_click() {
    activate_dark_mode()

    // Changer les variables locales du client
    if (window.localStorage["dark_mode"] == "user_forced") {
        window.localStorage["dark_mode"] = "user_desactivated";
    } else if ((window.localStorage["dark_mode"] == "user_desactivated") || (window.localStorage["dark_mode"] == "hour")) {
        window.localStorage["dark_mode"] = "user_forced";
    }
}



function activate_dark_mode() {
    // Toggle dark mode -- À CHANGER / LA VARIABLE window.localStorage["dark_mode"] STOCKE L'ÉTAT DU DARK MODE, PLUS BESOIN DE CHECK POUR CHAQUE DIV/CLASS
    if ($("body").hasClass("darkbody")) {
        $("body").removeClass("darkbody");
    } else {
        $("body").addClass("darkbody");
    }
    if ($("footer").hasClass("darkfoncé")) {
        $("footer").removeClass("darkfoncé");
    } else {
        $("footer").addClass("darkfoncé");
    }

    if ($("article").hasClass("darkbody")) {
        $("article").removeClass("darkbody");
    } else {
        $("article").addClass("darkbody");
    }
    if ($("div").hasClass("darkfoncé")) {
        $("div").removeClass("darkfoncé");
    } else {
        $("div").addClass("darkfoncé");
    }
    if ($("header").hasClass("darkfoncé")) {
        $("header").removeClass("darkfoncé");
    } else {
        $("header").addClass("darkfoncé");
    }
    if ($(".Plateforme").hasClass("darkbody")) {
        $(".Plateforme").removeClass("darkbody");
    } else {
        $(".Plateforme").addClass("darkbody");
    }
    if ($(".liste-équipe").hasClass("darkbody")) {
        $(".liste-équipe").removeClass("darkbody");
    } else {
        $(".liste-équipe").addClass("darkbody");
    }
    if ($(".liens-sociaux").hasClass("darkbody")) {
        $(".liens-sociaux").removeClass("darkbody");
    } else {
        $(".liens-sociaux").addClass("darkbody");
    }
    if ($("a").hasClass("darkbody")) {
        $("a").removeClass("darkbody");
    } else {
        $("a").addClass("darkbody");
    }
}


$(document).ready(function () {
    // Si darkmode à déjà été activé par l'utilisateur alors on le garde, sinon on le change en fonction de l'heure
    if (!window.localStorage["dark_mode"]) {
        window.localStorage["dark_mode"] = "hour";
    }
    if (window.localStorage["dark_mode"] == "user_forced") {
        activate_dark_mode();
    } else if (window.localStorage["dark_mode"] == "user_desactivated") {
        null;
    } else if (window.localStorage["dark_mode"] == "hour") {
        var d = new Date();
        var h = d.getHours();
        if (h > 18 || h < 8) {
            activate_dark_mode();
        } else {
            null;
        }
    }
});


// Change la taille de la bannière fixe lors du scroll down/up
window.onscroll = function () {
    scrollFunction()
};
function scrollFunction() {
    if (document.body.scrollTop > 300 || document.documentElement.scrollTop > 300) {
        document.getElementsByClassName("bannière")[0].style.height = "0px";
        document.getElementsByClassName("bannière")[0].style.opacity = "0%";
        document.documentElement.style.marginTop = "0px";
    } else if (document.body.scrollTop > 10 || document.documentElement.scrollTop > 10) {
        document.getElementsByClassName("bannière")[0].style.height = "70px";
        document.getElementsByClassName("bannière")[0].style.opacity = "100%";
        document.documentElement.style.marginTop = "70px";
    } else {
        document.getElementsByClassName("bannière")[0].style.height = "130px";
        document.getElementsByClassName("bannière")[0].style.opacity = "100%";
        document.documentElement.style.marginTop = "130px";
    }
}