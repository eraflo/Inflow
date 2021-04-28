$(document).ready(function() {
    $("#darkTrigger").click(function () {
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
    });
})


$(document).ready(function() {
    var d = new Date();
    var n = d.getHours();

    if (n > 18 || n < 8) {
        $("body").addClass("dark");
    }
});


// Change la taille de la bannière fixe lors du scroll down/up
window.onscroll = function() {
    scrollFunction()
};

function scrollFunction() {
    if (document.body.scrollTop > 300 || document.documentElement.scrollTop > 300) {
        document.getElementsByClassName("bannière")[0].style.height = "0px";
        document.documentElement.style.marginTop = "0px";
    } else if (document.body.scrollTop > 10 || document.documentElement.scrollTop > 10) {
        document.getElementsByClassName("bannière")[0].style.height = "70px";
        document.documentElement.style.marginTop = "70px";
    } else {
        document.getElementsByClassName("bannière")[0].style.height = "130px";
        document.documentElement.style.marginTop = "130px";
    }
}