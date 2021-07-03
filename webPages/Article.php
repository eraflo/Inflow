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
        <div class="cardGallery hcenter">
            <?php while($c = $categories->fetch()) { ?>
                <a href="tmpl_categories.php?id=<?= $c['id'] ?>" class="noUnderline">
                    <div class="cardArticle cardCategory">
                        <p class="title"> <?= $c['nom'] ?></p>
                        <p class="desc"> <?= $c['description'] ?></p>
                        <p class="author"> <?= $c['auteur'] ?></p>
                    </div>
                </a>
            <?php } ?>
        </div>
        <br/>
        <h1>News :</h1>
        <!--Affiche les titres de chaque article, cliquer dessus amène sur l'article-->
        <div class="cardGallery hcenter" id="actualisation_publication">
            <?php while($a = $articles->fetch()) { ?>
                <a href="Publication.php?id=<?= $a['id'] ?>" class="noUnderline" title="<?= $a['descriptions'] ?>">
                    <div class="cardArticle" style='<?php if(!empty($a['avatar_article'])) { ?>
                    background: center url("membres/avatars_article/<?= $a['avatar_article'] ?>");
                    background-size: cover;backdrop-filter: grayscale(25%) blur(3px);<?php } ?>'>
                        <p class="title"><?= $a['titre'] ?></p>
                        <p class="date"><?= date('m/d', strtotime($a['date_time_publication'])) ?></p>
                        <?php if(isset($a['id_auteur'])) {
                        $search_auteur->execute(array($a['id_auteur'])); 
                        $sa = $search_auteur->fetch();?>
                            <p class="author"> <?= $sa['pseudo'] ?></p>
                        <?php } else { ?>
                            <p class="author"> <?= $a['auteur'] ?></p>
                        <?php } ?>
                        <?php if(isset($a["option"])) { ?>
                            <span class="option" style="background=var(--color-background-alt)"><?= $a["option"] ?>
                        <?php } elseif(strtotime($a["date_time_publication"]) >= strtotime('-3 days')) { ?>
                            <span class="option" style="background:pink">Nouveau!</span>
                        <?php } ?>
                    </div>
                </a>
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
