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
    <div class="articleGallery hcenter" id="actualisation">
            <?php while($d = $data->fetch()) { 
                $search_art = $bdd->prepare("SELECT * FROM articles WHERE id = ?");
                $search_art->execute(array($d["id"]));
                $s = $search_art->fetch();
                ?>
                <a href="Publication.php?id=<?= $s['id'] ?>" class="noUnderline cardArticleContainer">
                <?php if(!empty($s['avatar_article'])) { ?>
                    <img class="cardArticleImage" src="membres/avatars_article/<?php echo $s['avatar_article']; ?>" href="Publication.php?id=<?= $s['id'] ?>" style="width:100%;" loading="lazy" />
                <?php } ?>
                    <div class="cardArticleContent">
                        <p class="cardArticleTitle"><?= $s['titre'] ?></p>
                        <p class="cardArticleMainText"><?= $s['descriptions'] ?></p>
                        <?php 
                        if(isset($s['id_auteur'])) {
                            $search_auteur->execute(array($s['id_auteur'])); 
                            $sa = $search_auteur->fetch();?>
                            <p class="cardArticleSecondaryText"> <?= $sa['pseudo'] ?></p>
                            <?php } else { ?>
                                <p class="cardArticleSecondaryText"> <?= $s['auteur'] ?></p>
                            <?php } ?>
                    </div>
                </a>
            <?php } ?>
        </div>

</div>
<div class="right">
</div>




<?php
include 'tmpl_bottom.php'; 
?>

<!--Application des fichiers css exclusifs-->
<link type="text/css" href="style\menu.css" rel="stylesheet">
<link type="text/css" href="style\articles.css" rel="stylesheet">
