

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
var last_check_for_comments = 0;
function check_new_comments(bypass = false) {
    var d = new Date();
    var n = d.getTime();

    if ((n > last_check_for_comments + 500) || bypass) {
        // cooldown  (200ms)               bypass (automatic function)
        bypass = false;
        if ($(window).scrollTop() + ($(window).height() * 0.7) >= $(document).height() - $("footer").height()) {
            bypass = true;
        }
        last_check_for_comments = n;
        var max_height = $(".right").height();
        var actual_height = $(".Commentaires").height();
        var comment_avg_height = 200;
        var number_of_comments = $(".comments .CBlock").length;
        if ((max_height > actual_height + comment_avg_height) || bypass) {
            if(bypass) {
                load_comments(number_of_comments, 3);
            } else {
                load_comments(number_of_comments, 1);
            }
        }
    }
}
function load_comments(start = 0, size = 3) {
    var comments_html_response = 0;
    $.when($.ajax({
        method: "GET",
        url: url,
        data: { load: "comments", start: start, size: size},
        success: function (result) {
            comments_html_response = result;
        }
    })).done(function () {
        var div_comments = $(".comments");

        if (comments_html_response) {
            div_comments.append(comments_html_response);
            check_new_comments(true);
        }
    });
}
function load_comment_section() {
    var comment_section_html_response = 0;
    $.when($.ajax({
        method: "GET",
        url: url,
        data: { load: "html"},
        success: function (result) {
            comment_section_html_response = result;
        }
    })).done(function () {
        var div_comments = $(".Commentaires");
        div_comments.html(comment_section_html_response);
        load_comments();
    });
}
$(document).ready(load_comment_section());
window.addEventListener('scroll', function() { setTimeout( function() { check_new_comments(); }, 200);});



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