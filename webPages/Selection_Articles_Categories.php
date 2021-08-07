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
        <div class="cardGallery hcenter">
            <?php while($a = $articles->fetch()) { 
                $view = $bdd->prepare("SELECT * FROM historique WHERE id = ?");
                $view->execute(array($a['id']));
                $vues = $view->rowCount();
                $comment = $bdd->prepare('SELECT * FROM commentaires WHERE id_article = ?');
                $comment->execute(array($a['id']));
                $comment = $comment->rowCount();?>
            <a href="Gestion_Articles_Categories.php?id=<?= $a['id'] ?>" class="noUnderline"
                title="<?= $a['descriptions'] ?>">
                <div class="cardArticle">
                    <p class="title"><?= $a['titre'] ?></p>
                    <p class="date"> <?= $a['date_time_publication'] ?></p><br />
                    <div class="articleMenuButtonElement">
                        <a href="#" class="noUnderline" title="Nombre de vues">
                            <img src="assets/vues.png" class="visitsButton">
                            <p><?= $vues ?></p>
                        </a>
                    </div><br />
                    <p><?= $comment ?></p>
                    <?php if(isset($a['id_auteur'])) {
                            $search_auteur->execute(array($a['id_auteur']));
                            $sa = $search_auteur->fetch();?>
                    <p class="author"> <?= $sa['pseudo'] ?></p>
                    <?php } else { ?>
                    <p class="author"> <?= $a['auteur'] ?></p>
                    <?php } ?>
                </div>
            </a>
            <?php } ?>
        </div>
    </article>
</div>

<!--Application des fichiers css exclusifs-->
<link type="text/css" href="style\articles.css" rel="stylesheet">