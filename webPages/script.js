$(document).ready(function() {
    $("#darkTrigger").click(function() {
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
    });
})


$(document).ready(function() {
    var d = new Date();
    var n = d.getHours();

    if (n > 18 || n < 8) {
        $("body").addClass("dark");
    }
});