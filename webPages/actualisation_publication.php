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
