


function delete_link(element) {
    function error(message = "Invalide !") {
        $("#links_list_error_message").addClass("links_list_error");
        $("#links_list_error_message").css("display", "initial");
        $("#links_list_error_message").html(message);
        $("#links_list_send").addClass("links_list_error");
    }
    var link = $(element).parent().parent().children().attr("href");
    var response = 0;
    
    $("#links_list_error_message").removeClass("links_list_error");
    $("#links_list_send").removeClass("links_list_error");

    $.when($.ajax({
        method: "POST",
        data: { nohead: "true", social_link: link, social_link_delete: "true" },
        success: function (result) {
            response = result;
        },
    })).done(function () {
        if (JSON.stringify(response).substring(1,6) != "error") {
            $("#links_list_list").children().each(function () {
                if ($(this).children().attr("href") == response['deleted']) {
                    $(this).remove();
                    return false;
                }
            });
        } else {
            error(response);
        }
    });
}


function send_new_link() {
    function error(message = "Invalide !") {
        $("#links_list_error_message").addClass("links_list_error");
        $("#links_list_error_message").css("display", "initial");
        $("#links_list_error_message").html(message);
        $("#links_list_send").addClass("links_list_error");
    }
    var link = $("#social_link").val();
    var response = 0;
    
    $("#links_list_error_message").removeClass("links_list_error");
    $("#links_list_send").removeClass("links_list_error");

    if (link == "") {
        error("Ne peut pas être vide");
        return;
    }
    
    $.when($.ajax({
        method: "POST",
        data: { nohead: "true", social_link: link },
        success: function (result) {
            response = result;
        },
    })).done(function () {
        if (JSON.stringify(response).substring(1,6) != "error") {
            var link_name = response["link_name"];
            var link_url = response["link_url"];
            html = '<div class="links_list"><a class="PActions links_text" href="'+link_url+'"  rel="noreferrer noopener" title="'+link_name+'">'+
                   '<img src="https://www.google.com/s2/favicons?domain='+link_url+'" height="16" /><span>'+link_name+'</span></a >'+
                   '<a><img class="links_buttons" id="one" src="assets/delete.png" onclick="delete_link(this)" /></a></div >'
            $("#links_list_list").append(html);
            $("#social_link").val("");
        } else {
            error(response);
        }
    });
}

