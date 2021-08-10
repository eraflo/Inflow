<?php
session_start();
$bdd = new PDO("mysql:host=127.0.0.1;dbname=inflow;charset=utf8", "root", "");

$data = $bdd->prepare("SELECT * FROM historique WHERE id_pseudo = ? ORDER BY date_visite DESC");
$data->execute(array($_SESSION["id"]));

$search_auteur = $bdd->prepare('SELECT * FROM `membres` WHERE id = ?');

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
    <?php if($data->rowCount() > 0) { ?>
        <div class="card_article">
            <?php while($d = $data->fetch()) { 
                $search_art = $bdd->prepare("SELECT * FROM articles WHERE id = ?");
                $search_art->execute(array($d["id"]));
                $s = $search_art->fetch(); ?>
                <div class="card">
                    <a href="Publication.php?id=<?= $s['id'] ?>">
                        <div class="text_card">
                            <div class="titre"><?= $s['titre'] ?></div>
                            <?php if(isset($s['id_auteur'])) {
                                $search_auteur->execute(array($s['id_auteur'])); 
                                $sa = $search_auteur->fetch();?>
                                <div class="auteur"> <?= $sa['pseudo'] ?></div>
                            <?php } else { ?>
                                <div class="auteur"> <?= $s['auteur'] ?></div>
                            <?php } ?>
                            <div class="description"><?= $s['descriptions'] ?></div>
                        </div>
                        <div class="miniature">
                            <?php if(!empty($s['avatar_article'])) { ?>
                                <picture>
                                    <source srcset="membres/avatars_article/<?=$a['avatar_article'].'.webp'?>" type="image/webp">
                                    <img src="membres/avatars_article/<?=$a['avatar_article']?>" type="image/png">
                                </picture>
                            <?php } ?>
                        </div>
                    </a>
                </div>
            <?php } ?>
        </div>
    <?php } else { ?>
        <h1>Aucun Historique</h1>
    <?php } ?>

</div>
<div class="right">
</div>




<?php
include 'tmpl_bottom.php'; 
?>

<!--Application des fichiers css exclusifs-->
<link type="text/css" href="style\menu.css" rel="stylesheet">
<link type="text/css" href="style\articles.css" rel="stylesheet">
