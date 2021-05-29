<?php
session_start();
$bdd = new PDO("mysql:host=127.0.0.1;dbname=articles;charset=utf8", "root", "");
$bdd2 = new PDO("mysql:host=127.0.0.1;dbname=espace_membre;charset=utf8", "root", "");
$articlesParPage = 6;
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


                    <div class="articleGallery hcenter">
                        <?php while($a = $articles->fetch()) { ?>
                            <a href="Publication.php?id=<?= $a['id'] ?>" class="cardArticleLink cardArticleElement">
                            <?php if(!empty($a['avatar_article'])) { ?>
                                <img src="membres/avatars_article/<?php echo $a['avatar_article']; ?>" href="Publication.php?id=<?= $a['id'] ?>" style="width:100%">
                            <?php } ?>
                                <div class="cardArticleContent">
                                    <p class="cardArticleTitle"><?= $a['titre'] ?></p>
                                    <p class="cardArticleDesc"><?= $a['descriptions'] ?></p>
                                    <p class="cardArticleAuthor"><?= $a['auteur'] ?></p>
                                </div>
                            </a>
                        <?php } ?>
                        <div class="articleGalleryPageContainer hcenter vcenter">
                        <?php
                        for($i=1;$i<=$pagesTotales;$i++) {
                            if($i == $pageCourante) {
                                echo '<a class="selected articleGalleryPageElement">'.$i.' </a>';
                            } else {
                                echo '<a class="articleGalleryPageElement" href="Article.php?page='.$i.'">'.$i.'</a>';
                            }
                        }
                        ?>
                        </div>
                    </div>