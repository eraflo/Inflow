var past_searches = {};

// Script pour la barre de recherche
$(document).ready(function () {
    $('#search').on("input", function() {
        var search = $(this).val();
        
        if (search in past_searches) {
            $('#result-search').html(past_searches[search]);
        } else if(search != "") {
            $.ajax({
                type: 'GET',
                url: "recherche.php",
                data: 'user=' + encodeURIComponent(search),
                success: function(data) {
                    if(data != "") {
                        $('#result-search').html(data);
                    } else {
                        $('#result-search').html("<div>Aucune correspondance</div>");
                    }
                    past_searches[search] = data;
                }
            });
        } else {
            $('#result-search').html("");
        }
    });
});
