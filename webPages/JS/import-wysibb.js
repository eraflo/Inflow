

// Script pour la barre de recherche
$(document).ready(function() {
    $('#search').keyup(function() {
        $('#result-research').html('');
        var research = $(this).val();

        if(research != "") {
            $.ajax({
                type: 'GET',
                url: "recherche.php",
                data: 'user=' + encodeURIComponent(research),
                success: function(data) {
                    if(data != "") {
                        $('#result-research').append(data);
                    } else {
                        document.getElementById('result-research').innerHTML = "<div>Aucune correspondance</div>"
                    }
                }
            });
        }
    });
});
