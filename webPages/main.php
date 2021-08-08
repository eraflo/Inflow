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
            <div class="card_article">
                <?php while($a_n = $new->fetch()) { 
                    if($a_n["type_new"] == 2) {
                    ?>
                    <div class="card">
                        <a href="<?= $a_n["lien"] ?>" class="noUnderline">
                            <div class="text_card">
                                <div class="titre"><?= $a_n['nom'] ?></div>
                                <div class="description"><?= $a_n['lien'] ?></div>
                                <div class="date"><?= $a_n['horaire'] ?></div>
                            </div>
                        </a>
                    </div>
                    <?php } elseif($a_n["type_new"] == 0) { 
                        $n_art = $bdd->prepare('SELECT * FROM `articles` WHERE id = ?');
                        $n_art->execute(array($a_n['lien']));
                        $new_art = $n_art->fetch();?>
                        <div class="card">
                            <a href="Publication.php?id=<?= $new_art['id'] ?>" class="noUnderline">
                                <div class="text_card">
                                    <div class="titre"><?= $new_art['titre'] ?></div>
                                    <?php if(isset($new_art['id_auteur']) AND $new_art['id_auteur'] != NULL) {
                                        $search_auteur->execute(array($new_art['id_auteur'])); 
                                        $sa1 = $search_auteur->fetch();?>
                                        <div class="auteur"> <?= $sa1['pseudo'] ?></div>
                                    <?php } else { ?>
                                        <div class="auteur"> <?= $new_art['auteur'] ?></div>
                                    <?php } ?>
                                    <div class="description"><?= $new_art['descriptions'] ?></div>
                                    <div class="date"><?= $new_art['date_time_publication'] ?></div>
                                </div>
                                <div class="miniature">
                                    <?php if(!empty($new_art['avatar_article'])) { ?>
                                        <img src="membres/avatars_article/<?= $new_art['avatar_article'] ?>" />
                                    <?php } ?>
                                </div>
                                <?php if(isset($a["option"])) { ?>
                                    <div class="new"><?= $new_art["option"] ?></div>
                                <?php } elseif(strtotime($new_art["date_time_publication"]) >= strtotime('-3 days')) { ?>
                                    <div class="new">New</div>
                                <?php } ?>
                            </a>
                        </div>
                    <?php } 
                } ?>
            </div>
        <?php } ?>


        <h1>Recommandations :</h1>
        <!--Affiche des recommendations d'articles à lire-->
        <div class="card_article">
            <?php while($a_r = $recom->fetch()) { 
                ?>
                <div class="card">
                    <a href="Publication.php?id=<?= $a_r['id'] ?>" class="noUnderline">
                        <div class="text_card">
                            <div class="titre"><?= $a_r['titre'] ?></div>
                            <?php 
                            if(isset($a_r['id_auteur']) AND $a_r['id_auteur'] != NULL) {
                            $search_auteur->execute(array($a_r['id_auteur'])); 
                            $sa1 = $search_auteur->fetch();?>
                                <div class="auteur"> <?= $sa1['pseudo'] ?></div>
                            <?php } else { ?>
                                <div class="auteur"> <?= $a_r['auteur'] ?></div>
                            <?php } ?>
                            <div class="description"><?= $a_r['descriptions'] ?></div>
                            <div class="date"><?= $a_r['date_time_publication'] ?></div>
                        </div>
                        <div class="miniature">
                            <?php if(!empty($a_r['avatar_article'])) { ?>
                                <img src="membres/avatars_article/<?= $a_r['avatar_article'] ?>" />
                            <?php } ?>
                        </div>
                        <?php if(isset($a_r["option"])) { ?>
                            <div class="new"><?= $a_r["option"] ?></div>
                        <?php } elseif(strtotime($a_r["date_time_publication"]) >= strtotime('-3 days')) { ?>
                            <div class="new">New</div>
                        <?php } ?>
                    </a>
                </div>
            <?php } ?>
        </div>
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

