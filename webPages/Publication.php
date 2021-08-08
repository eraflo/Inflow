<!--Page où apparaissent les publications-->
<?php
session_start();
$bdd = new PDO("mysql:host=127.0.0.1;dbname=inflow;charset=utf8", "root", "");
include('filtre.php');

include 'stats_visites_site.php';

if(isset($_GET['id']) AND !empty($_GET['id'])) {
    $get_id = htmlspecialchars($_GET['id']);
    $article = $bdd->prepare('SELECT * FROM articles WHERE id = ?');
    $article->execute(array($get_id));

    if($article->rowCount() == 1) {
        $article = $article->fetch();
        $id = $article['id'];
        $titre = $article['titre'];
        $contenu = $article['contenu'];
        $auteur = $article['auteur'];
        $cat = $article['id_categories'];
        $req_categorie = $bdd->prepare('SELECT * FROM `categories` WHERE id = ?');
        $req_categorie->execute(array($article['id_categories']));
        $categorie = $req_categorie->fetch();
        if(!empty($categorie)) {
            $categorie = $categorie['nom'];
        } else {
            $categorie = "";
        }

        $likes = $bdd->prepare('SELECT id FROM likes WHERE id_article = ?');
        $likes->execute(array($id));
        $likes = $likes->rowCount();

        $dislikes = $bdd->prepare('SELECT id FROM dislikes WHERE id_article = ?');
        $dislikes->execute(array($id));
        $dislikes = $dislikes->rowCount();

    } else {
        die('Cette article n\'existe pas !!!');
    }
} else {
    die('Erreur');
}

if(isset($_SESSION) AND !empty($_SESSION)) {
    $verifie = $bdd->prepare("SELECT * FROM historique WHERE id_pseudo = ? AND id = ?");
    $verifie->execute(array($_SESSION['id'], $id));
    $verifie->fetch();
    if($verifie->rowCount() < 1) {
        $ins_view = $bdd->prepare("INSERT INTO historique(id_pseudo, id, date_visite, type_hist, ip) VALUES(?, ?, NOW(), ?, ?)");
        $ins_view->execute(array($_SESSION["id"], $id, 0, $_SERVER['REMOTE_ADDR']));
    }
} else {
    $verifie = $bdd->prepare("SELECT * FROM historique WHERE ip = ? AND id = ?");
    $verifie->execute(array($_SERVER['REMOTE_ADDR'], $id));
    $verifie->fetch();
    if($verifie->rowCount() < 1) {
        $ins_view = $bdd->prepare("INSERT INTO historique(id_pseudo, id, date_visite, type_hist, ip) VALUES(?, ?, NOW(), ?, ?)");
        $ins_view->execute(array(0, $id, 0, $_SERVER['REMOTE_ADDR']));
    }
}


$view = $bdd->prepare("SELECT * FROM historique WHERE id = ?");
$view->execute(array($id));
$vues = $view->rowCount();

$get_id_cat = htmlspecialchars($_GET['id']);
$article_cat = $bdd->prepare('SELECT * FROM articles WHERE id = ?');
$article_cat->execute(array($get_id_cat));
$article_cat = $article_cat->fetch(); 
$cat = $article_cat['id_categories'];

$reco_article = $bdd->prepare("SELECT * FROM articles WHERE id_categories = ? ORDER BY date_time_publication DESC LIMIT 3");
$reco_article->execute(array($cat));
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

        <!--Affiche les articles-->
        <h1>
            <?= $titre ?>
        </h1>
        <?php if(isset($_SESSION['redacteur']) AND $_SESSION['redacteur'] == 1 AND isset($_SESSION)) { ?>
            <!--Edition--><a href="Gestion_Articles_Categories.php?id=<?= $get_id ?>" class="" title="Modifier l'article"><img class="editButton" src="assets/edit.png" title="Modifier l'article" /></a>
            <!--Statistiques-->
        <?php } ?>
        <div>
            <span>Publié le <?= $article['date_time_publication'] ?> par <?= $article['auteur'] ?></span><br/><br/>
        </div>
        <div class="article">
            <?= html_entity_decode($contenu) ?>
        </div>
        <div class="articleMenuButtonContainer">
            <div class="articleMenuButtonElement"><a href="#" class="" title="Nombre de vues"><img src="assets/vues.png" class="visitsButton"><p><?= $vues ?></p></a></div>
            <div class="articleMenuButtonElement"><a href="Action.php?t=1&id=<?= $id ?>" class="" title="J'aime"><img src="assets/like.png" class="likeButton"><p><?= $likes ?></p></a></div>
            <div class="articleMenuButtonElement"><a href="Action.php?t=2&id=<?= $id ?>" class="" title="Je n'aime pas"><img src="assets/dislike.png"class="dislikeButton"><p><?= $dislikes ?></p></a></div>
        </div>
    </article>

    <article class="RecommendationArticle">
        <h1>Recommandations en lien avec cet article :</h1>
        <?php if ($reco_article->rowCount() > 1) { ?>
            <div class="card_article">
            <?php while($a = $reco_article->fetch()) { 
                if(isset($a['id_categories']) AND !empty($a['id_categories']) AND $a['id_categories'] != NULL) {
                    if($a['id'] != $article['id']) {?>
                        <div class="card">
                            <a href="Publication.php?id=<?= $a['id'] ?>" class="" title="<?= $a["date_time_publication"] ?>">
                                <div class="text_card">
                                    <div class="titre"><?= $a['titre'] ?></div>
                                    <?php 
                                    if(isset($a['id_auteur'])) {
                                        $search_auteur->execute(array($a['id_auteur'])); 
                                        $sa = $search_auteur->fetch();?>
                                        <div class="auteur"> <?= $sa['pseudo'] ?></div>
                                    <?php } else { ?>
                                        <p class="auteur"> <?= $a['auteur'] ?></div>
                                    <?php } ?>
                                    <div class="description"><?= $a['descriptions'] ?></div>
                                </div>
                                <div class="miniature">
                                    <?php if(!empty($a['avatar_article'])) { ?>
                                        <img src="membres/avatars_article/<?= $a['avatar_article'] ?>" />
                                    <?php } ?>
                                </div>
                            </a>
                        </div>
                <?php }
                } 
            } ?>
            </div>
        <?php } else { ?>
            <p>Aucune Recommendation</p>
        <?php } ?>
    </article>
</div>

<div class="right">
    <div class="Commentaires">

    </div>
</div>
<?php 
// Le bas de l'interface est ajouté après le contenu
include 'tmpl_bottom.php'; 
?>

<!--Application des fichiers css et js exclusifs-->
<link type="text/css" href="style\articles.css" rel="stylesheet">
<link type="text/css" href="style\commentaires.css" rel="stylesheet">
<script src="JS/comments.js" defer></script>

