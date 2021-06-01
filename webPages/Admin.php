<!--Page pour les admins, à améliorer pour gérer commentaires, articles, connexion...-->
<!--Connecte à base de données + début gérer accès membres-->
<?php
session_start();
$bdd = new PDO("mysql:host=127.0.0.1;dbname=inflow;charset=utf8", "root", "");

if(!isset($_SESSION['admin']) OR $_SESSION['admin'] != 1 OR !isset($_SESSION) OR empty($_SESSION)) {
    header("Location: main.php");
}

if(isset($_GET['type']) AND $_GET['type'] == 'membre') {
    if(isset($_GET['admin']) AND !empty($_GET['admin'])) {

        $admin = (int) $_GET['admin'];
        $req = $bdd->prepare('UPDATE membres SET admin = 1 WHERE id = ?');
        $req->execute(array($admin));
        $nadmin = $bdd->query('SELECT * FROM membres');
        $newadmin = $nadmin->fetch();

        $_SESSION['admin'] = $newadmin['admin'];
    }
}

if(isset($_GET['type']) AND $_GET['type'] == 'membre') {
    if(isset($_GET['redacteur']) AND !empty($_GET['redacteur'])) {

        $redacteur = (int) $_GET['redacteur'];
        $req = $bdd->prepare('UPDATE membres SET redacteur = 1 WHERE id = ?');
        $req->execute(array($redacteur));
        $nconf = $bdd->query('SELECT * FROM membres');
        $newconf = $nconf->fetch();
        $_SESSION['redacteur'] = $newconf['redacteur'];
    }
}

if(isset($_GET['supprime']) AND !empty($_GET['supprime'])) {
    $supprime = (int) $_GET['supprime'];
    $req = $bdd->prepare('DELETE FROM membres WHERE id = ?');
    $req->execute(array($supprime));
}

$membres = $bdd->query('SELECT * FROM membres ORDER BY id DESC');
include 'tmpl_top.php';
?>
            <?php
            include 'LEFT/begin.php';
            include 'LEFT/categories.php';
            include 'LEFT/end.php';
            ?>
            <!--Début de là où on pourra mettre du texte-->
            <div class="middle">
                <div class="articleGallery articleGalleryProfiles hcenter" style="">
                    <?php while($m = $membres->fetch()) { ?>
                    <div class="cardArticleContainer cardArticleContainerProfiles">
                        <?php if($m['avatar'] != NULL) { ?><a href="Profil.php?id=<?= $m['id'] ?>" class="noUnderline"><img class="cardArticleImageProfiles avatar" src="membres/avatars/<?php echo $m['avatar']; ?>"><?php } ?></a>
                        <div class="cardArticleContent cardArticleContentProfiles">
                            <span class="cardArticleTitle">ID <?= $m['id'] ?></span>
                            <a class="cardArticleTitle" href="Profil.php?id=<?= $m['id'] ?>">PSEUDO <?= $m['pseudo'] ?></a>
                            <?php if(($m['admin'] == 0)&&($m['redacteur'] == 0)) { ?><div class="">
                                <span>COMMANDS </span> 
                                <?php if($m['admin'] == 0) { ?><span class="cardArticleMainText"><a href="Admin.php?type=membre&admin=<?= $m['id'] ?>">Admin</a></span><?php } ?>
                                <?php if($m['redacteur'] == 0) { ?><span class="cardArticleMainText"><a href="Admin.php?type=membre&redacteur=<?= $m['id'] ?>">Rédacteur</a></span><?php } ?>
                                <?php if($m['admin'] == 0) { ?><span class="cardArticleMainText"><a href="Admin.php?type=membre&supprime=<?= $m['id'] ?>">Supprimer</a></span><?php } ?>
                            </div><?php } ?>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>

            <div class="right"></div>
<?php 
// Le bas de l'interface est ajouté après le contenu
include 'tmpl_bottom.php'; 
?>
