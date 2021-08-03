<?php
session_start();
$bdd = new PDO("mysql:host=127.0.0.1;dbname=inflow;charset=utf8", "root", "");
include('filtre.php');

$emoji_replace = array(':leflow:', ':surprise:', ':revolutiooooon:', ':fumer:', ':axelitoutou:', ':revolutiooooontoutou:', 'revolutiooooon2:');
$emoji_new = array('<img src="assets/les_logos_pour_les_widgets.png" />', '<img src="assets/les_logos_pour_les_widgets_1.png" />', '<img src="assets/les_logos_pour_les_widgets_3.png" />', '<img src="assets/les_logos_pour_les_widgets_2.png" />', '<img src="assets/les_logos_pour_les_widgets_5.png" />', '<img src="assets/les_logos_pour_les_widgets_6.png" />', '<img src="assets/les_logos_pour_les_widgets_4.png" />');

$get_id = htmlspecialchars($_GET['id']);
$commentaires = $bdd->prepare("SELECT * FROM commentaires WHERE id_article = ? ORDER BY id DESC");
$commentaires->execute(array($get_id));


if(isset($_GET['load']) && ($_GET['load'] == "true")) { ?>
<div class='form_post_comment'>
    <h2 style="margin:15px">Commentaires :</h2>
    <textarea style="resize:vertical;width:98%;margin:15px;" id="commentaire" placeholder="Votre commentaire"></textarea><br/>
    <button style="margin:15px" onclick="post_comment()">Poster</button>
</div>
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

<?php } elseif(isset($_POST) && !empty($_POST)) {
    if(!empty($_SESSION)) {
        if(isset($_POST['commentaire']) AND !empty($_POST['commentaire'])) {
            $pseudo = htmlspecialchars($_SESSION['pseudo']);
            $id_pseudo = intval($_SESSION['id']);
            $commentaire = htmlspecialchars($_POST['commentaire']);
            $ins = $bdd->prepare("INSERT INTO commentaires (pseudo, commentaire, id_article, id_pseudo) VALUES (?, ?, ?, ?)");
            $ins->execute(array($pseudo, $commentaire, $get_id, $id_pseudo));
            $msg = "Votre commentaire a été posté.";
            $lastcom = $commentaire;
        } else {
            $msg = "Le champ est vide, remplissez le pour poster votre commentaire";
        }
    } else {
        $msg = "Vous n'êtes pas membre, vous ne pouvez pas poster de commentaires, inscrivez-vous !!!";
    }
    echo $msg;
} else {
    echo "error (both post and get are set or unset)";
} ?>