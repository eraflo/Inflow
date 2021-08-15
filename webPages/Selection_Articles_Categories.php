<?php
// Page sur laquelle on va avoir le choix de selectionner un article ou une catégorie


$articlesParPage = 10;
$categoriesParPage = 6;
$articlesTotalReq = $bdd->query('SELECT id FROM `articles`');
$articlesTotal = $articlesTotalReq->rowCount();
$categoriesTotalReq = $bdd->query('SELECT id FROM `categories`');
$categoriesTotal = $categoriesTotalReq->rowCount();
$pagesTotales = max(ceil($articlesTotal/$articlesParPage), ceil($categoriesTotal/$categoriesParPage));

if(isset($_GET['page']) AND !empty($_GET['page']) AND $_GET['page'] > 0 AND $_GET['page'] <= $pagesTotales) {
    $_GET['page'] = intval($_GET['page']);
    $pageCourante = $_GET['page'];

} else {
    $pageCourante = 1;
}
$depart_article = ($pageCourante-1)*$articlesParPage;
$depart_categorie = ($pageCourante-1)*$categoriesParPage;

$articles = $bdd->query('SELECT * FROM articles ORDER BY id DESC LIMIT 10 OFFSET '.$depart_article);
$auteurs = $bdd->query('SELECT * FROM `membres` WHERE redacteur = 1');
$categories = $bdd->query('SELECT * FROM categories ORDER BY id DESC LIMIT 6 OFFSET '.$depart_categorie);
$search_auteur = $bdd->prepare('SELECT * FROM `membres` WHERE id = ?');

include 'tmpl_top.php';
include 'MODULES/begin_left.php';
include 'MODULES/end.php';
?>

<div class="middle">
    <article>
        <?php if($categories->rowCount() > 0) { ?>
        <h2 title="<?=$categoriesParPage?> par page max" >Catégories</h1>
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
        <?php } else { ?>
        <h2>Pas de catégorie</h2>
        <?php } ?>
        <?php if($articles->rowCount() > 0) { ?>
        <h1 title="<?=$articlesParPage?> par page max">Articles</h1>
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
                                <img class="to_invert" src="assets/vues.png"> <?= $vues ?><br/>
                                <img class="to_invert" src="assets/commentaires.png"> <?= $comment ?>
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
        <?php } else { ?>
        <h2>Pas d'article</h2>
        <?php } ?>
        <div class="pageBox hcenter vcenter">
            <?php for($i=1;$i<=$pagesTotales;$i++) {
                if($i == $pageCourante) {
                    echo '<a class="page selected">'.$i.' </a>';
                } else {
                    echo '<a class="page" href="?page='.$i.'">'.$i.'</a>';
                }
            }?>
        </div>
    </article>
</div>

<!--Application des fichiers css exclusifs-->
<link type="text/css" href="style\articles.css" rel="stylesheet">
<link type="text/css" href="style\pages.css" rel="stylesheet">

