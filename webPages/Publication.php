<!--Page où apparaissent les publications-->
<?php
session_start();
$bdd = new PDO("mysql:host=127.0.0.1;dbname=inflow;charset=utf8", "root", "");
include('filtre.php');

include 'stats_visites_site.php';

//appel parser.php
require_once "JBBCode/Parser.php";

if(isset($_GET['id']) AND !empty($_GET['id'])) {
    $get_id = htmlspecialchars($_GET['id']);
    $article = $bdd->prepare('SELECT * FROM articles WHERE id = ?');
    $article->execute(array($get_id));

    //Changer code BBCode en html
    $parser = new JBBCode\Parser();
    $parser->addCodeDefinitionSet(new JBBCode\DefaultCodeDefinitionSet());
    $parser->addBBCode("quote", '<blockquote>{param}</blockquote>');
    $parser->addBBCode("&nbsp;", '<br/>{param}');

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

        $vues = 0; // pas encore implémenté

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


$commentaires = $bdd->prepare("SELECT * FROM commentaires WHERE id_article = ? ORDER BY id DESC");
$commentaires->execute(array($get_id));
$reco_article = $bdd->prepare("SELECT * FROM articles WHERE id_categories = ? LIMIT 3");
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
        
        <div>
            <span>Publié le <?= $article['date_time_publication'] ?> par <?= $article['auteur'] ?></span>
            <?php if(isset($_SESSION['redacteur']) AND $_SESSION['redacteur'] == 1 AND isset($_SESSION)) { ?>
            <a href="Gestion_Articles_Categories.php?id=<?= $get_id ?>" class="noUnderline"><img class="editButton" src="assets/edit.png" title="Modifier l'article" /></a>
            <?php } ?>
        </div>
        <p class="article">
            <?php //affiche ici le contenu en html reçu de l'éditeur de texte
            $parser->parse($contenu);
            echo $parser->getAsHtml();
            ?>
        </p>
        <div class="articleMenuButtonContainer">
            <div class="articleMenuButtonElement"><a href="#" class="noUnderline"><img src="assets/vues.png" class="visitsButton"><p><?= $vues ?></p></a></div>
            <div class="articleMenuButtonElement"><a href="Action.php?t=1&id=<?= $id ?>" class="noUnderline"><img src="assets/like.png" class="likeButton"><p><?= $likes ?></p></a></div>
            <div class="articleMenuButtonElement"><a href="Action.php?t=2&id=<?= $id ?>" class="noUnderline"><img src="assets/dislike.png"class="dislikeButton"><p><?= $dislikes ?></p></a></div>
        </div>
    </article>

    <article class="RecommendationArticle">
        <?php if($reco_article->rowCount() > 0) { ?>
            <h1>Recommandations en lien avec cet article :</h1>
            <?php while($a = $reco_article->fetch()) { 
                if(isset($a['id_categories']) AND $a['id_categories'] != NULL AND $a['id_categories'] == $article['id_categories'] AND $a['id'] != $article['id']) {?>
                    <a href="Publication.php?id=<?= $a['id'] ?>" class="noUnderline cardArticleContainer">
                    <?php if(!empty($a['avatar_article'])) { ?>
                        <img class="cardArticleImage" src="membres/avatars_article/<?php echo $a['avatar_article']; ?>" href="Publication.php?id=<?= $a['id'] ?>" style="width:100%;" loading="lazy" />
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
                <?php } else { ?>
                    <p>Aucune Recommendation</p>
            <?php } ?>
        <?php } 
        } ?>
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
