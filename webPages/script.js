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
    // Toggle dark mode

    $(".headerElement").each(function (index) {
        $(this).fadeOut(0);
    });

    $("*").addClass("noTransition");

    if (document.documentElement.getAttribute("user-color-mode") == "user_forced")
        document.documentElement.setAttribute("user-color-mode", "user_desactivated");
    else if (document.documentElement.getAttribute("user-color-mode") == "user_desactivated")
        document.documentElement.setAttribute("user-color-mode", "user_forced");
    else
        document.documentElement.setAttribute("user-color-mode", "user_forced");

    // Timeout nécessaire car le navigateur actualise les changements de "noTransition" trop rapidement
    setTimeout(function () {
        $("*").removeClass("noTransition");
    }, 10);

    $(".headerElement").each(function (index) {
        $(this).delay(150 * index).fadeIn(400);
    });
}


$(document).ready(function () {
    // Si darkmode à déjà été activé par l'utilisateur alors on le garde, sinon on le change en fonction de l'heure
    if (!window.localStorage["dark_mode"]) {
        window.localStorage["dark_mode"] = "hour";
    }
    if (window.localStorage["dark_mode"] == "user_forced") {
        activate_dark_mode();
        document.querySelector('input[type="checkbox"]').checked = true;
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


// Change la taille de la banniere fixe lors du scroll down/up

window.onscroll = function () {
    scrollFunction()
};
function scrollFunction() {
    if (document.body.scrollTop > 1000 || document.documentElement.scrollTop > 1000) {
        document.getElementsByClassName("banniere")[0].style.height = "0px";
        document.getElementsByClassName("banniere")[0].style.opacity = "0%";
    } else if (document.body.scrollTop > 80 || document.documentElement.scrollTop > 80) {
        document.getElementsByClassName("banniere")[0].style.height = "70px";
        document.getElementsByClassName("banniere")[0].style.opacity = "100%";
    } else {
        document.getElementsByClassName("banniere")[0].style.height = "130px";
        document.getElementsByClassName("banniere")[0].style.opacity = "100%";
    }
}

// Affiche les éléments du header petit à petit

$(document).ready(function () {

    if (!document.documentElement.getAttribute("user-color-mode") == "user_forced") {
        $(".headerElement").each(function (index) {
            $(this).fadeOut(0);
        });
        $(".headerElement").each(function (index) {
            $(this).delay(100 * index).fadeIn(1000);
        });
    }
});
