

function GetURLParameterValue(sParam) {
    var sPageURL = window.location.search.substring(1);
    var sURLVariables = sPageURL.split('&');
    for (var i = 0; i < sURLVariables.length; i++) 
    {
        var sParameterName = sURLVariables[i].split('=');
        if (sParameterName[0] == sParam) 
        {
            return sParameterName[1];
        }
    }
}
var publicationId = GetURLParameterValue("id");
var url = "comments.php?id=" + publicationId;
function load_comment_section() {
    var comment_section_html_response = 0;
    $.when($.ajax({
        method: "GET",
        url: url,
        data: { load: "true"},
        success: function (result) {
            comment_section_html_response = result;
        }
    })).done(function () {
        var div_comments = $(".Commentaires");
        div_comments.html(comment_section_html_response);
    });
}
$(document).ready(load_comment_section());


function post_comment() {
    var form_post_comment = $("#form_post_comment");
    var form_comment_data = { commentaire: $('#commentaire').val()};
    var response = 0;

    $.when($.ajax({
        method: "POST",
        url: url,
        data: form_comment_data,
        success: function (result) {
            response = result;
        }
    })).done(load_comment_section());
}