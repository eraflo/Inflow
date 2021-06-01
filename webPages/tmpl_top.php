<?php
?>
<!DOCTYPE html>
<html>
    <head>
        <!--Pour mettre des commentaires dans le code, respecter ma syntaxe-->
        <meta charset="UTF-8">
        <!-- Paramètre d'affichage mobile -->
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <!-- Gestion du navigateur IE -->
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Inflow</title>
        <!--Appliquer le style css et importer l'icone-->
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&family=Kalam:wght@300;400;700&family=Montserrat:ital,wght@0,300;0,400;0,500;0,700;0,900;1,300;1,400;1,500;1,700;1,900&family=Roboto:ital,wght@0,300;0,400;0,700;0,900;1,300;1,400;1,700;1,900&display=swap" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="style.css" />
        <link rel="icon" href="assets/Inflow_logo_64px.png" />
        <!--Importer les scripts-->
        <script src="JS/jquery-3.6.0.min.js"></script>
        <script type="text/javascript" src="JS/script.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <!--Charger ressources pour éditeur de texte-->
        <script src = "//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js" > </script>
        <script src = "http://cdn.wysibb.com/js/jquery.wysibb.min.js" > </script> 
        <link rel = "stylesheet" href = "http://cdn.wysibb.com/css/default/wbbtheme.css" />
        <script src="JS/fr.js"></script>
        <!--Script pour customiser éditeur de texte pour articles-->
        <script> 
            $(function() { 
                var Options = {
                    buttons: "bold,italic,underline,strike,|,sup,sub,|,img,video,link,|,bullist,numlist,|,fontcolor,fontsize,fontfamily,|,justifyleft,justifycenter,justifyright,|,quote,code,table,removeFormat",
                    lang: "fr",
                }
                $("#editor").wysibb(Options); 
            }) 
        </script>
        <!--Script pour la barre de recherche-->
        <script>
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
        </script>
        <script>
            // setInterval('load_page()', 10000);
            function load_page() {
                $('#actualisation').load('actualisation_page.php');
            }
        </script>
    </head>


    <body>
        <div class="main container">
            <!--Header, c'est-à-dire, le menu pour changer de page-->
            <header class="header container">
                <img class="banniere element" src="assets/banniere_twi.png" />
                <nav class="navBarHeader container element">
                    <div class="headerFirstElement element navBarHeaderElement"><a href="main.php">Menu</a></div>
                    <?php if(isset($_SESSION['redacteur']) AND $_SESSION['redacteur'] == 1 AND isset($_SESSION)) { ?>
                        <div class="headerFirstElement element navBarHeaderElement dropdown ">
                            <a href="Article.php">Article</a>
                            <div class="dropdown-content">
                                <div class="navBarHeaderElement"><a href="Poster.php">Poster</a></div>
                            </div>
                        </div>
                    <?php } else { ?>
                        <div class="navBarHeaderElement headerFirstElement"><a href="Article.php">Article</a></div>
                    <?php } ?>                    
                    <div class="headerFirstElement element navBarHeaderElement"><a href="Playlist.php">Playlist</a></div>
                    <div class="headerFirstElement element navBarHeaderElement dropdown "><a href="#">Espace Membre</a>
                        <div class="dropdown-content">
                            <?php if(empty($_SESSION)) { ?>
                            <div class="navBarHeaderElement"><a href="Inscription.php">Inscription</a></div>
                            <?php } ?>
                            <?php if(empty($_SESSION)) { ?>
                            <div class="navBarHeaderElement">
                                <a href="Connexion.php">Connexion</a></div>
                            <?php } ?>
                            <?php if(!empty($_SESSION)) { ?>
                            <div class="navBarHeaderElement">
                                <a href="Profil.php?id=<?= $_SESSION['id'] ?>">Profil</a></div>
                            <?php } ?>
                            <?php if(isset($_SESSION['admin']) AND $_SESSION['admin'] == 1 AND isset($_SESSION)) { ?>
                            <div class="navBarHeaderElement">
                                <a href="Admin.php">Admin</a>
                            </div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="headerFirstElement element navBarHeaderElement"><a href="Infos.php" id="Infos">Infos</a></div>
                    <div class="element search">
                        <form action="#">
                            <input type="text" placeholder="Recherche" id="search" name="search" value="" />
                        </form>
                        <div id="result-research"></div>
                    </div>
                </nav>
                <?php if(!isset($_COOKIE['accept_cookie'])) { ?>
                    <div class="element cookie-alert">En poursuivant votre navigation sur ce site, vous acceptez l'utilisation de cookies pour vous 
                        proposez des contenus et services adaptés à vos centres d'interêt.<br/>
                        <a class="cookie-alert-ok-button" href="accept_cookie.php">OK</a>
                    </div>
                <?php } ?>
            </header>