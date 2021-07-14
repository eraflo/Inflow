<?php
    include 'webp_convert.php';

    $files_avatars = scandir("membres/avatars");
    $files_avatars_global = scandir("membres/avatars/global");
    $files_avatars_articles = scandir("membres/avatars_article");

    if(isset($_GET["towebp"])) {
        generate_webp_image($_GET["towebp"]);
    }

    // get current url
    $protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";  
    $CurPageURL = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    $CurPageURL = explode("?", $CurPageURL)[0];

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
        <!-- Gestion du navigateur IE -->
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <!--Appliquer le style css et importer l'icone-->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Assistant&family=Lovers+Quarrel&family=PT+Serif:ital,wght@0,400;0,700;1,400;1,700&family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&family=Kalam:wght@300;400;700&family=Montserrat:ital,wght@0,300;0,400;0,500;0,700;0,900;1,300;1,400;1,500;1,700;1,900&family=Roboto:ital,wght@0,300;0,400;0,700;0,900;1,300;1,400;1,700;1,900&display=swap" media="none" onload="if(media!='all')media='all'">
        <noscript><link href="https://fonts.googleapis.com/css2?family=Assistant&family=Lovers+Quarrel&family=PT+Serif:ital,wght@0,400;0,700;1,400;1,700&family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&family=Kalam:wght@300;400;700&family=Montserrat:ital,wght@0,300;0,400;0,500;0,700;0,900;1,300;1,400;1,500;1,700;1,900&family=Roboto:ital,wght@0,300;0,400;0,700;0,900;1,300;1,400;1,700;1,900&display=swap" rel="stylesheet"></noscript>
        
        <link type="text/css" rel="stylesheet" href="style\style.css" media="none" onload="if(media!='all')media='all'">
        <noscript><link type="text/css" href="style\style.css" rel="stylesheet"></noscript>
        
        <!--Importer les scripts-->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

        <link rel="icon" href="assets/Inflow_logo_64px.png" />

        <!--Style-->
        <style>
            .image-gallery {
                display: block;
            }
            .image-box {
                display: flex;
                flex-flow: row;
            }
            .image-box-details {
                display: flex;
                flex-flow: column;
            }
            img {
                max-width: 50%;
            }
        </style>
    </head>
    <body>
        <div class="image-gallery">
        <?php foreach($files_avatars as $image){
            $megapath = 'membres/avatars/';
            $extension = pathinfo($megapath.$image, PATHINFO_EXTENSION);
            $path = pathinfo($megapath.$image, PATHINFO_BASENAME);
            if (($extension == 'png') || ($extension == 'jpg')) { 
                $dimensions = getimagesize($megapath.$path);
                $size = filesize($megapath.$path) / 1024; ?>
                <div class="image-box">
                    <img src="<?= $megapath.$path ?>" />
                    <div class="image-box-details">
                    <span><?= $megapath.$path ?></span>
                    <span><?= $dimensions[0]."x".$dimensions[1] ?></span>
                <?php if (file_exists($megapath.$path.'.webp')) { 
                $sizewebp = filesize($megapath.$path.".webp") / 1024 ?>
                    <span><?= $size."Ko - ".$sizewebp."Ko" ?></span>
                <?php } else { ?>
                    <span><?= $size."Ko" ?></span>
                    <button onclick="this.hidden=true;$.ajax('<?= $CurPageURL.'?towebp='.$megapath.$path ?>')">TO WEBP !!</button>
                <?php } ?>
                    </div>
                </div>
            <?php }
        } ?>
        <?php foreach($files_avatars_global as $image){
            $megapath = 'membres/avatars/global/';
            $extension = pathinfo($megapath.$image, PATHINFO_EXTENSION);
            $path = pathinfo($megapath.$image, PATHINFO_BASENAME);
            if (($extension == 'png') || ($extension == 'jpg')) { 
                $dimensions = getimagesize($megapath.$path);
                $size = filesize($megapath.$path) / 1024; ?>
                <div class="image-box">
                    <img src="<?= $megapath.$path ?>" />
                    <div class="image-box-details">
                    <span><?= $megapath.$path ?></span>
                    <span><?= $dimensions[0]."x".$dimensions[1] ?></span>
                <?php if (file_exists($megapath.$path.'.webp')) {
                $sizewebp = filesize($megapath.$path.".webp") / 1024 ?>
                    <span><?= $size."Ko - ".$sizewebp."Ko" ?></span>
                <?php } else { ?>
                    <span><?= $size."Ko" ?></span>
                    <button onclick="this.hidden=true;$.ajax('<?= $CurPageURL.'?towebp='.$megapath.$path ?>')">TO WEBP !!</button>
                <?php } ?>
                    </div>
                </div>
            <?php }
        } ?>
        <?php foreach($files_avatars_articles as $image){
            $megapath = 'membres/avatars_article/';
            $extension = pathinfo($megapath.$image, PATHINFO_EXTENSION);
            $path = pathinfo($megapath.$image, PATHINFO_BASENAME);
            if (($extension == 'png') || ($extension == 'jpg')) { 
                $dimensions = getimagesize($megapath.$path);
                $size = filesize($megapath.$path) / 1024; ?>
                <div class="image-box">
                    <img src="<?= $megapath.$path ?>" />
                    <div class="image-box-details">
                    <span><?= $megapath.$path ?></span>
                    <span><?= $dimensions[0]."x".$dimensions[1] ?></span>
                <?php if (file_exists($megapath.$path.'.webp')) {
                $sizewebp = filesize($megapath.$path.".webp") / 1024 ?>
                    <span><?= $size."Ko - ".$sizewebp."Ko" ?></span>
                <?php } else { ?>
                    <span><?= $size."Ko" ?></span>
                    <button onclick="this.hidden=true;$.ajax('<?= $CurPageURL.'?towebp='.$megapath.$path ?>')">TO WEBP !!</button>
                <?php } ?>
                    </div>
                </div>
            <?php }
        } ?>
        </div>
    </body>
</html>
