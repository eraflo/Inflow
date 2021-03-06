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
        <link type="text/css" rel="stylesheet" href="style\critical.css">
        <link rel="preconnect" href="https://fonts.gstatic.com">

        <!--Informations sur la page et open graph-->
        <title>Inflow</title>
        <!-- Paramètre d'affichage mobile -->
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0, minimum-scale=1.0">
        <meta name="description" content="Inflow est un média musical entièrement géré par des lycéens dont le but est de faire découvrir la musique urbaine à nos lecteurs, qu'ils soient néophytes ou expérimentés.">
        <!-- Gestion du navigateur IE -->
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <!--Appliquer le style css et importer l'icone-->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Assistant&family=Lovers+Quarrel&family=PT+Serif:ital,wght@0,400;0,700;1,400;1,700&family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&family=Kalam:wght@300;400;700&family=Montserrat:ital,wght@0,300;0,400;0,500;0,700;0,900;1,300;1,400;1,500;1,700;1,900&family=Roboto:ital,wght@0,300;0,400;0,700;0,900;1,300;1,400;1,700;1,900&display=swap" media="none" onload="if(media!='all')media='all'">
        <noscript><link href="https://fonts.googleapis.com/css2?family=Assistant&family=Lovers+Quarrel&family=PT+Serif:ital,wght@0,400;0,700;1,400;1,700&family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&family=Kalam:wght@300;400;700&family=Montserrat:ital,wght@0,300;0,400;0,500;0,700;0,900;1,300;1,400;1,500;1,700;1,900&family=Roboto:ital,wght@0,300;0,400;0,700;0,900;1,300;1,400;1,700;1,900&display=swap" rel="stylesheet"></noscript>
        
        <link type="text/css" rel="stylesheet" href="style\style_template.css" media="none" onload="if(media!='all')media='all'">
        <noscript><link type="text/css" href="style\style_template.css" rel="stylesheet"></noscript>
        <link type="text/css" rel="stylesheet" href="style\style_connexion_inscription.css" media="none" onload="if(media!='all')media='all'">
        <noscript><link type="text/css" href="style\style_connexion_inscription.css" rel="stylesheet"></noscript>
        
        <!--Importer les scripts-->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js" defer></script>
        <script type="text/javascript" src="JS/script.js" defer></script>
        <script type="text/javascript" src="JS/recherche.js" defer></script>

        <!--OPEN GRAPH-->
        <meta property="og:url" content="http://inflow.fr.nf/" />
        <meta property="og:site_name" content="InflowOfficiel<?php if(isset($categorie) && !empty($categorie)){echo ' - '.$categorie;} ?>" />
        <meta property="og:type" content="object" />
        <meta property="og:title" content="<?php if(isset($auteur) && isset($titre)){echo $auteur.' - '.$titre;}?>" />
        <meta property="og:description" content="<?php if(isset($article['descriptions']) && !empty($article['descriptions'])){echo $article['descriptions'];} ?>" />
        <meta property="og:image" content="<?php if(isset($article['avatar_article']) && !empty($article['avatar_article'])){echo 'http://inflow.fr.nf/membres/avatars_article/'.$article['avatar_article'];}else{echo 'http://inflow.fr.nf/assets/banniere_twi.webp';} ?>" />
        <meta property="og:image:alt" content="Inflow" />
        <meta property="og:image:width" content="1200" />
        <meta property="og:image:height" content="600" />
        
        <link rel="icon" href="assets/Inflow_logo_64px.png" />
    </head>


    <body>
        <div class="main container">
            <!--Header, c'est-à-dire, le menu pour changer de page-->
            <header class="header container">
                <picture class="banniere element" height="130px" alt="Inflow bannière" >
                    <source class="banniere element" height="130px" srcset="assets/banniere_twi.webp" type="image/webp">
                    <img class="banniere element" height="130px" src="assets/banniere_twi.png" type="image/png">
                </picture>
                <nav class="navBarHeader container element can_rainbow2">
                    <?php if(isset($_SESSION['admin']) AND $_SESSION['admin'] == 1 AND isset($_SESSION)) { ?>
                        <div class="headerFirstElement element navBarHeaderElement dropdown">
                            <a href="main.php">Menu</a>
                            <div class="dropdown-content can_rainbow2">
                                <div class="navBarHeaderElement">
                                    <a href="publication_event.php">Nouveauté</a>
                                </div>
                            </div>
                        </div>
                    <?php } else { ?>
                        <div class="headerFirstElement element navBarHeaderElement dropdown">
                            <a href="main.php">Menu</a>
                        </div>
                    <?php } ?>
                    <?php if(isset($_SESSION['redacteur']) AND $_SESSION['redacteur'] == 1 AND isset($_SESSION)) { ?>
                        <div class="headerFirstElement element navBarHeaderElement dropdown ">
                            <a href="Article.php">Article</a>
                            <div class="dropdown-content can_rainbow2">
                                <div class="navBarHeaderElement"><a href="Poster.php">Poster</a></div>
                                <div class="navBarHeaderElement"><a href="Gestion_Articles_Categories.php">Gestion articles</a></div>
                            </div>
                        </div>
                    <?php } else { ?>
                        <div class="navBarHeaderElement headerFirstElement"><a href="Article.php">Article</a></div>
                    <?php } ?>                    
                    <div class="headerFirstElement element navBarHeaderElement"><a href="Playlist.php">Playlist</a></div>
                    <div class="headerFirstElement element navBarHeaderElement dropdown "><a href="<?php if(isset($_SESSION) AND !empty($_SESSION)){echo 'Profil.php?id='.$_SESSION['id'];}else{echo 'Connexion.php';}?>">Espace Membre</a>
                        <div class="dropdown-content can_rainbow2">
                            <?php if(empty($_SESSION)) { ?>
                            <div class="navBarHeaderElement"><a href="Inscription.php">Inscription</a></div>
                            <div class="navBarHeaderElement"><a href="Connexion.php">Connexion</a></div>
                            <?php } ?>
                            <?php if(isset($_SESSION) AND !empty($_SESSION)) { ?>
                                <div class="navBarHeaderElement"><a href="Parametres.php">Paramètres</a></div>
                            <?php } ?>
                            <?php if(isset($_SESSION['admin']) AND $_SESSION['admin'] == 1 AND isset($_SESSION)) { ?>
                                <div class="navBarHeaderElement"><a href="Admin.php">Admin</a></div>
                                <div class="navBarHeaderElement"><a href="Admin-images.php">Gestion Images</a></div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="headerFirstElement element search dropdown" id="search_form">
                        <form action="#">
                            <input type="text" placeholder="Recherche" id="search" name="search" value="" autocomplete="off"/>
                        </form>
                        <div id="result-search" class="result-search dropdown-content"></div>
                    </div>
                    <?php if(!empty($_SESSION)) { ?>
                        <div class="headerFirstElement element navBarHeaderElement dropdown" id="account_preview"><a href="#">Compte</a>
                            <div class="dropdown-content can_rainbow2" style="transform: translate(-112px); min-width: auto; width: max-content;">
                                <?php
                                    include 'MODULES/profil.php';
                                ?>
                            </div>
                        </div>
                    <?php } ?>
                </nav>
            </header>