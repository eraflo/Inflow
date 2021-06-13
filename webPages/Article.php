<!--Page recensant tout les articles -> quand clique sur titre article, rediriger sur article dans Publication.html-->
<?php
session_start();
$bdd = new PDO("mysql:host=127.0.0.1;dbname=inflow;charset=utf8", "root", "");

$articlesParPage = 12;
$articlesTotalReq = $bdd->query('SELECT id FROM `articles`');
$articlesTotal = $articlesTotalReq->rowCount();

$pagesTotales = ceil($articlesTotal/$articlesParPage);

include 'stats_visites_site.php';

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
                    <div class="articleCategoryGallery articleGallery hcenter">
                        <?php while($c = $categories->fetch()) { ?>
                            <a href="tmpl_categories.php?id=<?= $c['id'] ?>" class="noUnderline cardArticleContainer cardArticleContent">
                                <p class="cardArticleTitle"> <?= $c['nom'] ?></p>
                                <p class="cardArticleMainText"> <?= $c['description'] ?></p>
                                <p class="cardArticleSecondaryText"> <?= $c['auteur'] ?></p>
                            </a>
                        <?php } ?>
                    </div>
                    <br/>
                    <h1>News :</h1>
                    <!--Affiche les titres de chaque article, cliquer dessus amène sur l'article-->
                    <div class="articleGallery hcenter" id="actualisation">
                        <?php while($a = $articles->fetch()) { ?>
                            <a href="Publication.php?id=<?= $a['id'] ?>" class="noUnderline cardArticleContainer">
                            <?php if(!empty($a['avatar_article'])) { ?>
                                <img class="cardArticleImage" src="membres/avatars_article/<?php echo $a['avatar_article']; ?>" href="Publication.php?id=<?= $a['id'] ?>" style="width:100%">
                            <?php } ?>
                                <div class="cardArticleContent">
                                    <p class="cardArticleTitle"><?= $a['titre'] ?></p>
                                    <p class="cardArticleMainText"><?= $a['descriptions'] ?></p>
                                    <?php 
                                    if(isset($a['id_auteur'])) {
                                        $search_auteur->execute(array($a['id_auteur'])); 
                                        $sa = $search_auteur->fetch();?>
                                        <p class="cardArticleSecondaryText"> <?= $sa['pseudo'] ?></p>
                                        <?php } else { ?>
                                            <p class="cardArticleSecondaryText"> <?= $a['auteur'] ?></p>
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

