<?php
session_start();
$bdd = new PDO("mysql:host=127.0.0.1;dbname=articles;charset=utf8", "root", "");
$bdd2 = new PDO("mysql:host=127.0.0.1;dbname=espace_membre;charset=utf8", "root", "");

$articlesParPage = 12;
$articlesTotalReq = $bdd->query('SELECT id FROM articles');
$articlesTotal = $articlesTotalReq->rowCount();

$pagesTotales = ceil($articlesTotal/$articlesParPage);

if(isset($_GET['page']) AND !empty($_GET['page']) AND $_GET['page'] > 0 AND $_GET['page'] <= $pagesTotales) {
    $_GET['page'] = intval($_GET['page']);
    $pageCourante = $_GET['page'];

} else {
    $pageCourante = 1;
}

$depart = ($pageCourante-1)*$articlesParPage;
$articles = $bdd->query('SELECT * FROM articles ORDER BY date_time_publication DESC LIMIT '.$depart.','.$articlesParPage.''); 
?>


                    <div class="articleGallery hcenter" id="actualisation">
                        <?php while($a = $articles->fetch()) { ?>
                            <a href="Publication.php?id=<?= $a['id'] ?>" class="cardArticleLink cardArticleElement">
                            <?php if(!empty($a['avatar_article'])) { ?>
                                <img class="cardArticleImage" src="membres/avatars_article/<?php echo $a['avatar_article']; ?>" href="Publication.php?id=<?= $a['id'] ?>" style="width:100%">
                            <?php } ?>
                                <div class="cardArticleContent">
                                    <p class="cardArticleTitle"><?= $a['titre'] ?></p>
                                    <p class="cardArticleMainText"><?= $a['descriptions'] ?></p>
                                    <p class="cardArticleSecondaryText"><?= $a['auteur'] ?></p>
                                </div>
                            </a>
                        <?php } ?>
                    </div>