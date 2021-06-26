<?php
// Page sur laquelle on va avoir le choix de selectionner un article ou une catégorie


$articles = $bdd->query('SELECT * FROM articles');
$auteurs = $bdd->query('SELECT * FROM `membres` WHERE redacteur = 1');
$categories = $bdd->query('SELECT * FROM categories');
$search_auteur = $bdd->prepare('SELECT * FROM `membres` WHERE id = ?');




include 'tmpl_top.php';
include 'MODULES/begin_left.php';
include 'MODULES/end.php';
?>

<div class="middle">
    <article>
        <div class="articleGalleryArticles hcenter" id="actualisation">
            <?php while($a = $articles->fetch()) { ?>
                <a href="Gestion_Articles_Categories.php?id=<?= $a['id'] ?>" class="noUnderline cardArticleContainer">
                    <div class="cardArticleContent">
                        <p class="cardArticleTitle"><?= $a['titre'] ?></p>
                        <p class="cardArticleMainText"><?= $a['descriptions'] ?></p>
                        <?php if(isset($a['id_auteur'])) {
                            $search_auteur->execute(array($a['id_auteur']));
                            $sa = $search_auteur->fetch();?>
                            <p class="cardArticleSecondaryText"> <?= $sa['pseudo'] ?></p>
                        <?php } else { ?>
                            <p class="cardArticleSecondaryText"> <?= $a['auteur'] ?></p>
                        <?php } ?>
                        <p class="cardArticleSecondaryText"> <?= $a['date_time_publication'] ?></p>
                    </div>
                </a>
            <?php } ?>
        </div>
    </article>
</div>

<!--Application des fichiers css exclusifs-->
<link type="text/css" href="style\articles.css" rel="stylesheet">
