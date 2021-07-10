<?php
session_start();
$bdd = new PDO("mysql:host=127.0.0.1;dbname=inflow;charset=utf8", "root", "");

$new = $bdd->query("SELECT * FROM nouveauté ORDER BY date_time_publication DESC LIMIT 6");

$search_auteur = $bdd->prepare('SELECT * FROM `membres` WHERE id = ?');
$recom = $bdd->query('SELECT * FROM `articles` ORDER BY nombre_like DESC LIMIT 6');

include 'stats_visites_site.php';

// Le haut de l'interface est ajouté avant le contenu
include 'tmpl_top.php';
?>
<?php
include 'MODULES/begin_left.php';
include 'MODULES/categories.php';
include 'MODULES/stats_visites_site.php';
include 'MODULES/end.php';
?>
<!--Début de là où on pourra mettre du texte-->
<div class="middle">
    <article class="ProfilTxt MenuTxt">
        <h1> Qui sommes nous ? </h1>
        <p, style="font-family: sans-serif;"> Inflow est un média musical entièrement géré par des lycéens dont le but est 
            de faire découvrir la musique urbaine à nos lecteurs, qu'ils soient néophytes ou expérimentés.<br /><br />
            L'équipe d'Inflow vous souhaite une bonne lecture et une bonne écoute !<br /><br /><br />
        </p>

        <?php if($new->rowCount() > 0) {?>
            <h1>News :</h1>
            <!--Affiche des news-->
            <div class="cardGallery hcenter">
                <?php while($a_n = $new->fetch()) { 
                    if($a_n["type_new"] == 2) {
                    ?>
                        <a href="<?= $a_n["lien"] ?>" class="noUnderline">
                        <div class="cardArticle">
                            <p class="title"><?= $a_n['nom'] ?></p>
                            <p class="date"><?= $a_n['lien'] ?></p>
                            <p class="author"><?= $a_n['horaire'] ?></p><!--Anyr -> J'ai utilisé author parce que j'ai pas envie de m'embêter -->
                        </div>
                        </a>
                    <?php } elseif($a_n["type_new"] == 0) { 
                        $n_art = $bdd->prepare('SELECT * FROM `articles` WHERE id = ?');
                        $n_art->execute(array($a_n['lien']));
                        $new_art = $n_art->fetch();?>
                        <a href="Publication.php?id=<?= $new_art['id'] ?>" class="noUnderline">
                            <div class="cardArticle" style='<?php if(!empty($new_art['avatar_article'])) { ?>
                            background: center url("membres/avatars_article/<?= $new_art['avatar_article'] ?>");
                            background-size: cover;backdrop-filter: grayscale(25%) blur(3px);<?php } ?>'>
                                <p class="title"><?= $new_art['titre'] ?></p>
                                <p class="desc"><?= $new_art['descriptions'] ?></p>
                                <?php if(isset($new_art['id_auteur']) AND $new_art['id_auteur'] != NULL) {
                                $search_auteur->execute(array($new_art['id_auteur'])); 
                                $sa1 = $search_auteur->fetch();?>
                                    <p class="author"> <?= $sa1['pseudo'] ?></p>
                                <?php } else { ?>
                                    <p class="author"> <?= $new_art['auteur'] ?></p>
                                <?php } ?>
                            </div>
                        </a>
                    <?php } 
                } ?>
            </div>
            <?php } ?>


        <h1>Recommandations :</h1>
        <!--Affiche des recommendations d'articles à lire-->
        <div class="cardGallery hcenter">
            <?php while($a_r = $recom->fetch()) { 
                ?>
                <a href="Publication.php?id=<?= $a_r['id'] ?>" class="noUnderline">
                <?php if(!empty($a_r['avatar_article'])) { ?>
                    <img class="cardArticleImage" src="membres/avatars_article/<?php echo $a_r['avatar_article'].'.webp'; ?>" href="Publication.php?id=<?= $a_r['id'] ?>" style="width:100%;" loading="lazy"/>
                <?php } ?>
                    <div class="cardArticle" style='<?php if(!empty($a_r['avatar_article'])) { ?>
                    background: center url("membres/avatars_article/<?= $a_r['avatar_article'] ?>");
                    background-size: cover;backdrop-filter: grayscale(25%) blur(3px);<?php } ?>'>
                        <p class="title"><?= $a_r['titre'] ?></p>
                        <p class="desc"><?= $a_r['descriptions'] ?></p>
                        <?php 
                        if(isset($a_r['id_auteur']) AND $a_r['id_auteur'] != NULL) {
                        $search_auteur->execute(array($a_r['id_auteur'])); 
                        $sa1 = $search_auteur->fetch();?>
                            <p class="author"> <?= $sa1['pseudo'] ?></p>
                        <?php } else { ?>
                            <p class="author"> <?= $a_r['auteur'] ?></p>
                        <?php } ?>
                    </div>
                </a>
            <?php } ?>
        </div>
                    
        <br/><p> Pour nous suivre sur tous nos réseaux: </p>
        <a href="https://twitter.com/InflowOfficiel" rel="noreferrer noopener" target="_blank">
            <img src="assets/twitter.webp"
            class= "ImageLien noUnderline" loading="lazy" alt="twitter" />
        </a>
        <a href="https://www.instagram.com/inflow_officiel/?igshid=1642d7pjo8yi1" rel="noreferrer noopener" target="_blank">
            <img src="assets/instagram.webp"
            class= "ImageLien noUnderline" loading="lazy" alt="instagram" />
        </a>
        <a href="https://www.facebook.com/Inflow-100173238898216/" rel="noreferrer noopener" target="_blank">
            <img src="assets/facebook.webp"
            class= "ImageLien noUnderline" loading="lazy" alt="facebook" />
        </a>
        <a href="https://www.twitch.tv/inflowofficiel" rel="noreferrer noopener" target="_blank">
            <img src="assets/twitch.webp"
            class= "ImageLien noUnderline" loading="lazy" alt="twitch" />
        </a>
        <a href="https://www.youtube.com/channel/UC7cUqgADmD2xV9VDlt6NOXg" rel="noreferrer noopener" target="_blank">
            <img src="assets/youtube.webp"
            class= "ImageLien noUnderline" loading="lazy" alt="youtube" />
        </a>
    </article>
</div>
<div class="right"></div>
<?php 
// Le bas de l'interface est ajouté après le contenu
include 'tmpl_bottom.php'; 
?>

<!--Application des fichiers css exclusifs-->
<link type="text/css" href="style\menu.css" rel="stylesheet">
<link type="text/css" href="style\articles.css" rel="stylesheet">

