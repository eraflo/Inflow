<!--Charger base de donnée + Lorsque formulaire remplie pour poster un article, rentre les infos dans la base de donnée-->
<?php
session_start();
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
        <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,400;0,700;1,400;1,700&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@700&display=swap" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="style.css" />
        <link rel="icon" href="assets/Inflow_logo_64px.png" />
        <script src="jquery-3.6.0.min.js"></script>
        <script type="text/javascript" src="script.js"></script>
    </head>



    <body>
        <div class="main container">
            <!--Header, c'est-à-dire, le menu pour changer de page-->
            <header class="header container">
                <img class="banniere element" src="assets/banniere_twi.png" />
                <nav class="navBarHeader container element">
                    <div class="headerFirstElement element navBarHeaderElement"><a href="main.php">Menu</a></div>
                    <div class="headerFirstElement element navBarHeaderElement dropdown ">
                        <a href="#">Article</a>
                        <div class="dropdown-content">
                            <div class="navBarHeaderElement"><a href="Article.php">Article</a></div>
                            <?php if(isset($_SESSION['confirmer']) AND $_SESSION['confirmer'] == 1 AND isset($_SESSION)) { ?>
                            <div class="navBarHeaderElement">
                                <a href="Poster.php">Poster</a>
                            </div>
                            <?php } ?>
                        </div>
                    </div>
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
                            <input type="text" placeholder="Recherche" name="search">
                        </form>
                    </div>
                </nav>
            </header>