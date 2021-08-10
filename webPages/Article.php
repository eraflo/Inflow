<!--Page recensant tout les articles -> quand clique sur titre article, rediriger sur article dans Publication.html-->
<?php
session_start();
$bdd = new PDO("mysql:host=127.0.0.1;dbname=inflow;charset=utf8", "root", "");

include 'stats_visites_site.php';

$articlesParPage = 12;
$articlesTotalReq = $bdd->query('SELECT id FROM `articles`');
$articlesTotal = $articlesTotalReq->rowCount();

$pagesTotales = ceil($articlesTotal/$articlesParPage);

if(isset($_GET['page']) AND !empty($_GET['page']) AND $_GET['page'] > 0 AND $_GET['page'] <= $pagesTotales) {
    $_GET['page'] = intval($_GET['page']);
    $pageCourante = $_GET['page'];

} else {
    $pageCourante = 1;
}

$depart = ($pageCourante-1)*$articlesParPage;
$articles = $bdd->query('SELECT * FROM `articles` ORDER BY date_time_publication DESC LIMIT '.$depart.','.$articlesParPage.'');
$categories = $bdd->query('SELECT * FROM `categories`');
$search_auteur = $bdd->prepare('SELECT * FROM `membres` WHERE id = ?');

include 'tmpl_top.php';
?>
<?php
include 'MODULES/begin_left.php';
include 'MODULES/categories.php';
include 'MODULES/end.php';
?>


<!--Début de là où on pourra mettre du texte-->
<div class="middle">
    <article class="ProfilTxt">
        <h1>Catégories :</h1>
        <!--Affiche les catégories des articles-->
        <div class="card_article">
            <?php while($c = $categories->fetch()) { ?>
                <div class="card">
                    <a href="tmpl_categories.php?id=<?= $c['id'] ?>">
                        <div class="text_card">
                            <div class="cardArticle cardCategory">
                                <div class="titre"> <?= $c['nom'] ?></div>
                                <div class="auteur"> <?= $c['auteur'] ?></div>
                                <div class="description"> <?= $c['description'] ?></div>
                            </div>
                        </div>
                        <div class="miniature">
                            <?php if(!empty($c['avatar_categorie'])) { ?>
                                <picture>
                                    <source srcset="membres/avatars_categorie/<?= $c['avatar_categorie'].'.webp' ?>" type="image/webp">
                                    <img src="membres/avatars_categorie/<?= $c['avatar_categorie'] ?>" type="image/png" />
                                </picture>
                            <?php } ?>
                        </div>
                    </a>
                </div>
            <?php } ?>
        </div>
        <br/>
        <h1>News :</h1>
        <!--Affiche les titres de chaque article, cliquer dessus amène sur l'article-->
        <div class="card_article" id="actualisation_publication">
            <?php while($a = $articles->fetch()) { ?>
                <div class="card">
                    <a href="Publication.php?id=<?= $a['id'] ?>">
                        <div class="text_card">
                            <div class="titre"><?= $a['titre'] ?></div>
                            <?php if(isset($a['id_auteur'])) {
                                $search_auteur->execute(array($a['id_auteur'])); 
                                $sa = $search_auteur->fetch();?>
                                <div class="auteur"> <?= $sa['pseudo'] ?></div>
                            <?php } else { ?>
                                <div class="auteur"> <?= $a['auteur'] ?></div>
                            <?php } ?>
                            <div class="description"><?= $a['descriptions'] ?>"</div>
                            <div class="date"><?= date('m/d', strtotime($a['date_time_publication'])) ?></div>                        
                        </div>
                        <div class="miniature">
                            <?php if(!empty($a['avatar_article'])) { ?>
                                <picture>
                                    <source srcset="membres/avatars_article/<?=$a['avatar_article'].'.webp'?>" type="image/webp">
                                    <img src="membres/avatars_article/<?=$a['avatar_article']?>" type="image/png">
                                </picture>
                            <?php } ?>
                        </div>
                        <?php if(isset($a["option"])) { ?>
                            <div class="new"><?= $a["option"] ?></div>
                        <?php } elseif(strtotime($a["date_time_publication"]) >= strtotime('-3 days')) { ?>
                            <div class="new">New</div>
                        <?php } ?>
                    </a>
                </div>
            <?php } ?>
        </div>
        <div class="articleGalleryPageContainer hcenter vcenter">
            <?php for($i=1;$i<=$pagesTotales;$i++) {
                if($i == $pageCourante) {
                    echo '<a class="selected articleGalleryPageElement">'.$i.' </a>';
                } else {
                    echo '<a class="articleGalleryPageElement" href="Article.php?page='.$i.'">'.$i.'</a>';
                }
            }?>
        </div>

    </article>
</div>

<div class="right"></div>
<?php 
// Le bas de l'interface est ajouté après le contenu
include 'tmpl_bottom.php'; 
?>

<!--Application des fichiers css exclusifs-->
<link type="text/css" href="style\articles.css" rel="stylesheet">
