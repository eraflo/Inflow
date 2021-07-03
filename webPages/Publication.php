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

    if(!empty($_SESSION)) {
        if(isset($_POST['submit_commentaire'])) {
            if(isset($_POST['commentaire']) AND !empty($_POST['commentaire'])) {
                $pseudo = htmlspecialchars($_SESSION['pseudo']);
                $id_pseudo = intval($_SESSION['id']);
                $commentaire = htmlspecialchars($_POST['commentaire']);
                $ins = $bdd->prepare("INSERT INTO commentaires (pseudo, commentaire, id_article, id_pseudo) VALUES (?, ?, ?, ?)");
                $ins->execute(array($pseudo, $commentaire, $get_id, $id_pseudo));
                $msg = "Votre commentaire a été posté.";
                $lastcom = $commentaire;
                header("Location: Publication.php?id=".$get_id);
            } else {
                $msg = "Le champ est vide, remplissez le pour poster votre commentaire";
            }
        }
    } else {
        $msg = "Vous n'êtes pas membre, vous ne pouvez pas poster de commentaires, inscrivez-vous !!!";
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


$commentaires = $bdd->prepare("SELECT * FROM commentaires WHERE id_article = ? ORDER BY id DESC");
$commentaires->execute(array($get_id));
$reco_article = $bdd->prepare("SELECT * FROM articles WHERE id_categories = ? ORDER BY date_time_publication DESC LIMIT 3");
$reco_article->execute(array($cat));
$search_auteur = $bdd->prepare('SELECT * FROM `membres` WHERE id = ?');
$emoji_replace = array(':leflow:', ':surprise:', ':revolutiooooon:', ':fumer:', ':axelitoutou:', ':revolutiooooontoutou:', 'revolutiooooon2:');
$emoji_new = array('<img src="assets/les_logos_pour_les_widgets.png" />', '<img src="assets/les_logos_pour_les_widgets_1.png" />', '<img src="assets/les_logos_pour_les_widgets_3.png" />', '<img src="assets/les_logos_pour_les_widgets_2.png" />', '<img src="assets/les_logos_pour_les_widgets_5.png" />', '<img src="assets/les_logos_pour_les_widgets_6.png" />', '<img src="assets/les_logos_pour_les_widgets_4.png" />');
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
            <!--Edition--><a href="Gestion_Articles_Categories.php?id=<?= $get_id ?>" class="noUnderline" title="Modifier l'article"><img class="editButton" src="assets/edit.png" title="Modifier l'article" /></a>
            <!--Statistiques-->
        <?php } ?>
        <div>
            <span>Publié le <?= $article['date_time_publication'] ?> par <?= $article['auteur'] ?></span><br/><br/>
        </div>
        <div class="article">
            <?= html_entity_decode($contenu) ?>
        </div>
        <div class="articleMenuButtonContainer">
            <div class="articleMenuButtonElement"><a href="#" class="noUnderline" title="Nombre de vues"><img src="assets/vues.png" class="visitsButton"><p><?= $vues ?></p></a></div>
            <div class="articleMenuButtonElement"><a href="Action.php?t=1&id=<?= $id ?>" class="noUnderline" title="J'aime"><img src="assets/like.png" class="likeButton"><p><?= $likes ?></p></a></div>
            <div class="articleMenuButtonElement"><a href="Action.php?t=2&id=<?= $id ?>" class="noUnderline" title="Je n'aime pas"><img src="assets/dislike.png"class="dislikeButton"><p><?= $dislikes ?></p></a></div>
        </div>
    </article>

    <article class="RecommendationArticle">
        <h1>Recommandations en lien avec cet article :</h1>
        <?php if ($reco_article->rowCount() > 1) { ?>
            <div class="cardGallery">
            <?php while($a = $reco_article->fetch()) { 
                if(isset($a['id_categories']) AND !empty($a['id_categories']) AND $a['id_categories'] != NULL) {
                    if($a['id'] != $article['id']) {?>
                        <a href="Publication.php?id=<?= $a['id'] ?>" class="noUnderline" title="<?= $a["date_time_publication"] ?>">
                            <div class="cardArticle" style='<?php if(!empty($a['avatar_article'])) { ?>
                            background: center url("membres/avatars_article/<?= $a['avatar_article'] ?>");
                            background-size: cover;backdrop-filter: grayscale(25%) blur(3px);<?php } ?>'>
                                <p class="title"><?= $a['titre'] ?></p>
                                <p class="desc"><?= $a['descriptions'] ?></p>
                                <?php 
                                if(isset($a['id_auteur'])) {
                                    $search_auteur->execute(array($a['id_auteur'])); 
                                    $sa = $search_auteur->fetch();?>
                                    <p class="author"> <?= $sa['pseudo'] ?></p>
                                <?php } else { ?>
                                    <p class="author"> <?= $a['auteur'] ?></p>
                                <?php } ?>
                            </div>
                        </a>
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
        <form method="POST">
            <h2 style="margin:15px">Commentaires :</h2>
            <textarea name="commentaire" placeholder="Votre commentaire" style="resize:vertical;width:98%;margin:15px;"></textarea> <br/>
            <input type="submit" value="Poster" name="submit_commentaire", style="margin:15px;" />
        </form>
        <br/>
        <?php if(isset($msg)) { echo $msg; } ?>
        <br/>
        <div class="panel-wrapper">
            <a href="#show" class="show btn" id="show">Afficher commentaires</a> 
            <a href="#hide" class="hide btn" id="hide">Réduire commentaires</a>
            <div class="panel">
                <?php while($c = $commentaires->fetch()) {
                    $pseudoAvatar = $bdd->prepare("SELECT * FROM membres WHERE id = ? ORDER BY id DESC");
                    $pseudoAvatar->execute(array($c['id_pseudo']));
                    $avatarInfos = $pseudoAvatar->fetch(); ?>
                <div class="CBlock">
                    <?php if(!empty($avatarInfos)) { ?>
                        <a class="noUnderline" href="Profil.php?id=<?= $avatarInfos['id'] ?>"><img src="membres/avatars/<?php echo $avatarInfos['avatar']; ?>" width="50"></a>
                    <?php } ?>
                    
                    <a href="Profil.php?id=<?= $avatarInfos['id'] ?>"><div class=NCapsule><b><?= $c['pseudo'] ?><br /></b></div></a>
                    <?php $c['commentaire'] = str_replace($emoji_replace, $emoji_new, $c['commentaire']); ?>
                    <?php $c['commentaire'] = Filtre($c['commentaire']); ?>
                    <div class="CText"><br /><?= $c['commentaire'] ?><br/></div>
                </div>
                <?php } ?>
            </div>
            <div class="fade"></div>
        </div>
    </div>
</div>
<?php 
// Le bas de l'interface est ajouté après le contenu
include 'tmpl_bottom.php'; 
?>

<!--Application des fichiers css exclusifs-->
<link type="text/css" href="style\articles.css" rel="stylesheet">
<link type="text/css" href="style\commentaires.css" rel="stylesheet">
