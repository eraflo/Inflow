<!--Page où apparaissent les publications-->
<?php
session_start();
$bdd = new PDO("mysql:host=127.0.0.1;dbname=inflow;charset=utf8", "root", "");
include('filtre.php');
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

    if($article->rowCount() == 1) {
        $article = $article->fetch();
        $id = $article['id'];
        $titre = $article['titre'];
        $contenu = $article['contenu'];

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
                <article>

                    <!--Affiche les articles-->
                    <h1>
                        <?= $titre ?>
                    </h1>
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
            </div>

            <div class="right">
                <div class="Commentaires">
                    <h2>Commentaires :</h2>
                    <form method="POST">
                        <textarea name="commentaire" placeholder="Votre commentaire" style="resize:vertical;width:99%"></textarea> <br/>
                        <input type="submit" value="Poster" name="submit_commentaire" />
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
                                <?php if(!empty($avatarInfos)) { ?>
                                    <a class="noUnderline" href="Profil.php?id=<?= $avatarInfos['id'] ?>"><img src="membres/avatars/<?php echo $avatarInfos['avatar']; ?>" class="avatar" width="50"></a>
                                <?php } ?>
                                <b><a href="Profil.php?id=<?= $avatarInfos['id'] ?>"><?= $c['pseudo'] ?></a> :</b>
                                <?php $c['commentaire'] = str_replace($emoji_replace, $emoji_new, $c['commentaire']); ?>
                                <?php $c['commentaire'] = Filtre($c['commentaire']); ?>
                                <?= $c['commentaire'] ?> <br/>
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