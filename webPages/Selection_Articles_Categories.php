<?php
// Page sur laquelle on va avoir le choix de selectionner un article ou une catégorie


$articles = $bdd->query('SELECT * FROM articles ORDER BY id DESC');
$auteurs = $bdd->query('SELECT * FROM `membres` WHERE redacteur = 1');
$categories = $bdd->query('SELECT * FROM categories ORDER BY id DESC');
$search_auteur = $bdd->prepare('SELECT * FROM `membres` WHERE id = ?');

include 'tmpl_top.php';
include 'MODULES/begin_left.php';
include 'MODULES/end.php';
?>

<div class="middle">
    <article>
        <h2>Catégories</h1>
        <div class="card_article">
            <?php while($c = $categories->fetch()) { ?>
                <div class="card">
                    <a href="Gestion_Articles_Categories.php?type=categorie&id=<?= $c['id'] ?>">
                        <div class="text_card">
                            <div class="titre"><?= $c['nom'] ?></div>
                            <div class="auteur"><?= $c['auteur'] ?></div>
                            <div class="description"><?= $c['description'] ?></div>
                            <div class="date"><?= $c['date_time_publication'] ?></div>
                        </div>
                        <div class="miniature">
                            <?php if(!empty($c['avatar_categorie'])) { ?>
                                <img src="membres/avatars_categorie/<?= $c['avatar_categorie'] ?>" />
                            <?php } ?>
                        </div>
                    </a>
                </div>
            <?php } ?>
        </div>
        <h1>Articles</h1>
        <div class="card_article">
            <?php while($a = $articles->fetch()) { 
                $view = $bdd->prepare("SELECT * FROM historique WHERE id = ?");
                $view->execute(array($a['id']));
                $vues = $view->rowCount();
                $comment = $bdd->prepare('SELECT * FROM commentaires WHERE id_article = ?');
                $comment->execute(array($a['id']));
                $comment = $comment->rowCount();?>
                <div class="card">
                    <a href="Gestion_Articles_Categories.php?type=article&id=<?= $a['id'] ?>">
                        <div class="text_card">
                            <div class="titre"><?= $a['titre'] ?></div>
                            <?php if(isset($a['id_auteur'])) {
                                $search_auteur->execute(array($a['id_auteur']));
                                $sa = $search_auteur->fetch();?>
                                <div class="auteur"> <?= $sa['pseudo'] ?></div>
                            <?php } else { ?>
                                <div class="auteur"> <?= $a['auteur'] ?></div>
                            <?php } ?>
                            <div class="description">
                                <img src="assets/vues.png"> <?= $vues ?><br/>
                                <img src="assets/commentaires.png"> <?= $comment ?>
                            </div>
                            <div class="date"> <?= $a['date_time_publication'] ?></div>
                        </div>
                        <div class="miniature">
                            <?php if(!empty($a['avatar_article'])) { ?>
                                <img src="membres/avatars_article/<?= $a['avatar_article'] ?>" />
                            <?php } ?>
                        </div>
                    </a>
                </div>
            <?php } ?>
        </div>
    </article>
</div>

<!--Application des fichiers css exclusifs-->
<link type="text/css" href="style\articles.css" rel="stylesheet">