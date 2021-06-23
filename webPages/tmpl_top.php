<?php
// compteur de visites
include('stats_visites_site.php');
?>
<!DOCTYPE html>
<html lang="FR-fr">
    <head>
        <!--Pour mettre des commentaires dans le code, respecter ma syntaxe-->
        <meta charset="UTF-8">
        <!--Optimisation de livraison-->
        <link type="text/css" rel="stylesheet" href="critical.css">
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link rel="preconnect" href="http://cdn.wysibb.com">
        <link rel="preconnect" href="http://ajax.googleapis.com">

        <!--Informations sur la page et open graph-->
        <title>Inflow</title>
        <!-- Paramètre d'affichage mobile -->
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=5.0, minimum-scale=1.0">
        <meta name="description" content="Inflow est un média musical entièrement géré par des lycéens dont le but est de faire découvrir la musique urbaine à nos lecteurs, qu'ils soient néophytes ou expérimentés.">
        <!-- Gestion du navigateur IE -->
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <!--Appliquer le style css et importer l'icone-->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Lovers+Quarrel&family=PT+Serif:ital,wght@0,400;0,700;1,400;1,700&family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&family=Kalam:wght@300;400;700&family=Montserrat:ital,wght@0,300;0,400;0,500;0,700;0,900;1,300;1,400;1,500;1,700;1,900&family=Roboto:ital,wght@0,300;0,400;0,700;0,900;1,300;1,400;1,700;1,900&display=swap" media="none" onload="if(media!='all')media='all'">
        <noscript><link href="https://fonts.googleapis.com/css2?family=Lovers+Quarrel&family=PT+Serif:ital,wght@0,400;0,700;1,400;1,700&family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&family=Kalam:wght@300;400;700&family=Montserrat:ital,wght@0,300;0,400;0,500;0,700;0,900;1,300;1,400;1,500;1,700;1,900&family=Roboto:ital,wght@0,300;0,400;0,700;0,900;1,300;1,400;1,700;1,900&display=swap" rel="stylesheet"></noscript>
        
        <link type="text/css" rel="stylesheet" href="style.css" media="none" onload="if(media!='all')media='all'">
        <noscript><link type="text/css" href="style.css" rel="stylesheet"></noscript>
        
        <!--Importer les scripts-->
        <script src="JS/jquery-3.6.0.min.js" defer></script>
        <script type="text/javascript" src="JS/script.js" defer></script>
        <script type="text/javascript" src="JS/import-search.js" defer></script>
        
        <link rel="icon" href="assets/Inflow_logo_64px.png" />
    </head>


    <body>
        <div class="main container">
            <!--Header, c'est-à-dire, le menu pour changer de page-->
            <header class="header container">
                <img class="banniere element" src="assets/banniere_twi.webp" height="130px" loading="lazy" alt="Inflow bannière" />
                <nav class="navBarHeader container element">
                    <div class="element navBarHeaderElement" style="min-height:80px"></div>
                    <div class="headerFirstElement element navBarHeaderElement"><a href="main.php">Menu</a></div>
                    <?php if(isset($_SESSION['redacteur']) AND $_SESSION['redacteur'] == 1 AND isset($_SESSION)) { ?>
                        <div class="headerFirstElement element navBarHeaderElement dropdown ">
                            <a href="Article.php">Article</a>
                            <div class="dropdown-content">
                                <div class="navBarHeaderElement"><a href="Poster.php">Poster</a></div>
                                <div class="navBarHeaderElement"><a href="Gestion_Articles_Categories.php">Gestion articles</a></div>
                            </div>
                        </div>
                    <?php } else { ?>
                        <div class="navBarHeaderElement headerFirstElement"><a href="Article.php">Article</a></div>
                    <?php } ?>                    
                    <div class="headerFirstElement element navBarHeaderElement"><a href="Playlist.php">Playlist</a></div>
                    <div class="headerFirstElement element navBarHeaderElement dropdown "><a href="<?php if(isset($_SESSION) AND !empty($_SESSION)){echo 'Profil.php?id='.$_SESSION['id'];}else{echo 'Connexion.php';}?>">Espace Membre</a>
                        <div class="dropdown-content">
                            <?php if(empty($_SESSION)) { ?>
                            <div class="navBarHeaderElement"><a href="Inscription.php">Inscription</a></div>
                            <div class="navBarHeaderElement"><a href="Connexion.php">Connexion</a></div>
                            <?php } ?>
                            <?php if(isset($_SESSION) AND !empty($_SESSION)) { ?>
                                <div class="navBarHeaderElement"><a href="Parametres.php">Paramètres</a></div>
                            <?php } ?>
                            <?php if(isset($_SESSION['admin']) AND $_SESSION['admin'] == 1 AND isset($_SESSION)) { ?>
                                <div class="navBarHeaderElement">
                                    <a href="Admin.php">Admin</a>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="headerFirstElement element navBarHeaderElement"><a href="Infos.php" id="Infos">Infos</a></div>
                    <div class="headerFirstElement element search">
                        <form action="#">
                            <input type="text" placeholder="Recherche" id="search" name="search" value="" />
                        </form>
                        <div id="result-research"></div>
                    </div>
                    <?php if(!empty($_SESSION)) { ?>
                        <div class="headerFirstElement element navBarHeaderElement dropdown "><a href="#">Compte</a>
                            <div class="dropdown-content" style="transform: translate(-85px); min-width: auto; width: max-content;">
                                <?php
                                    include 'MODULES/profil.php';
                                ?>
                            </div>
                        </div>
                    <?php } ?>
                </nav>
                <?php if(!isset($_COOKIE['accept_cookie'])) { ?>
                    <div class="element cookie-alert">En poursuivant votre navigation sur ce site, vous acceptez l'utilisation de cookies pour vous 
                        proposez des contenus et services adaptés à vos centres d'interêt.<br/>
                        <a class="cookie-alert-ok-button" href="accept_cookie.php">OK</a>
                    </div>
                <?php } ?>
            </header>