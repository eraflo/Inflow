
$(document).ready(function () {
    $("#password_visibility").click(function () {
        var sources = ["assets/afficher.png", "assets/cacher.png"];
        if($("#password_visibility").attr("src") == sources[1]){
            $("#password_visibility").attr("src", sources[0]);
            $("#password_input").attr("type", "password");
        } else {
            $("#password_visibility").attr("src", sources[1]);
            $("#password_input").attr("type", "text");
        }
    });
});
