<?php
session_start();
$bdd = new PDO("mysql:host=127.0.0.1;dbname=inflow;charset=utf8", "root", "");

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
?>

<div class="card_article" id="actualisation_publication">
    <?php while($a = $articles->fetch()) { ?>
        <div class="card">
            <a href="Publication.php?id=<?= $a['id'] ?>" class="noUnderline" >
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

                    <?php if(isset($a["option"])) { ?>
                        <div class="new"><?= $a["option"] ?></div>
                    <?php } elseif(strtotime($a["date_time_publication"]) >= strtotime('-3 days')) { ?>
                        <div class="new">New</div>
                    <?php } ?>
                </div>
                <div class="miniature">
                    <?php if(!empty($a['avatar_article'])) { ?>
                            <img class="cardArticleImage" src="membres/avatars_article/<?= $a['avatar_article'] ?>" />
                    <?php } ?>
                </div> 
            </a>
        </div>
    <?php } ?>
</div>
