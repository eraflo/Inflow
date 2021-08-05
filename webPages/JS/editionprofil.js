





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
        if (response != "error") {
            var link_name = response["link_name"];
            var link_url = response["link_url"];
            html = `
        <a href="`+ link_url +`" class="noUnderline PActions links_list" rel="noreferrer noopener" title="`+ link_name +`">
            <img src="https://www.google.com/s2/favicons?domain=`+ link_url +`" height="16" />
            `+ link_name +`
        </a>
        <br/>
            `
            $("#links_list_list").append(html);
            $("#social_link").val("");
        } else {
            error();
        }
    });
}

