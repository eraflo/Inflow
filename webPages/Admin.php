<!--Page pour les admins, à améliorer pour gérer commentaires, articles, connexion...-->
<!--Connecte à base de données + début gérer accès membres-->
<?php
session_start();
$bdd = new PDO("mysql:host=127.0.0.1;dbname=inflow;charset=utf8", "root", "");

if(!isset($_SESSION['admin']) OR $_SESSION['admin'] != 1 OR !isset($_SESSION) OR empty($_SESSION)) {
    header("Location: main.php");
}
include 'stats_visites_site.php';

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

if(isset($_GET['type']) AND $_GET['type'] == 'membre') {
    if(isset($_GET['supprime']) AND !empty($_GET['supprime'])) {
        $actif = (int) $_GET['supprime'];
        $statut = $bdd->prepare('SELECT * FROM membres WHERE id = ?');
        $statut->execute(array($actif));
        $stat = $statut->fetch();
        if($stat['actif'] == 0) {
            $req = $bdd->prepare('UPDATE membres SET actif = 1 WHERE id = ?');
            $req->execute(array($actif));
            $nconf = $bdd->query('SELECT * FROM membres');
            $newconf = $nconf->fetch();
            $_SESSION['actif'] = $newconf['actif'];
        } else {
            $req2 = $bdd->prepare('UPDATE membres SET actif = 0 WHERE id = ?');
            $req2->execute(array($actif));
            $nconf = $bdd->query('SELECT * FROM membres');
            $newconf = $nconf->fetch();
            $_SESSION['actif'] = $newconf['actif'];
        }
    }
}

$articlesParPage = 20;
$articlesTotalReq = $bdd->query('SELECT id FROM `membres`');
$articlesTotal = $articlesTotalReq->rowCount();

$pagesTotales = ceil($articlesTotal/$articlesParPage);

if(isset($_GET['page']) AND !empty($_GET['page']) AND $_GET['page'] > 0 AND $_GET['page'] <= $pagesTotales) {
    $_GET['page'] = intval($_GET['page']);
    $pageCourante = $_GET['page'];

} else {
    $pageCourante = 1;
}

$depart = ($pageCourante-1)*$articlesParPage;
$membres = $bdd->query('SELECT * FROM membres ORDER BY id DESC LIMIT '.$depart.','.$articlesParPage.'');
include 'tmpl_top.php';
?>
<?php
include 'MODULES/begin_left.php';
include 'MODULES/categories.php';
include 'MODULES/end.php';
?>
<!--Début de là où on pourra mettre du texte-->
<div class="middle">
    <div class="cardGallery hcenter" style="">
        <?php while($m = $membres->fetch()) { ?>
            <a href="Profil.php?id=<?= $m['id'] ?>" class="noUnderline" title="<?= $m['pseudo']?>    ID : <?= $m['id'] ?>">
                <div class="cardArticle">
                    <img style="width:300%" class="" src="membres/avatars/<?php echo $m['avatar'].'.webp'; ?>" loading="lazy" />
                </div>    
            </a>
            <!-- Pour toi flo ;)
            <div class="cardArticle cardArticleContentProfiles">
                ID <span class="title"><?= $m['id'] ?></span>
                PSEUDO <a class="cardArticleTitle" href="Profil.php?id=<?= $m['id'] ?>"><?= $m['pseudo'] ?></a>
                <?php if(($m['admin'] == 0) OR ($m['redacteur'] == 0)) { ?>
                    <div class="">
                        <span>COMMANDS </span> 
                        <?php if($m['admin'] == 0) { ?><span class="cardArticleMainText"><a href="Admin.php?type=membre&admin=<?= $m['id'] ?>" onclick="return confirm('Voulez-vous vraiment le rendre admin?')">Admin</a></span><?php } ?>
                        <?php if($m['redacteur'] == 0) { ?><span class="cardArticleMainText"><a href="Admin.php?type=membre&redacteur=<?= $m['id'] ?>" onclick="return confirm('Voulez-vous vraiment le rendre rédacteur?')">Rédacteur</a></span><?php } ?>
                        <?php if($m['admin'] == 0) { ?> 
                            <?php if($m['actif'] == 0) { ?> 
                                <span class="cardArticleMainText"><a href="Admin.php?type=membre&supprime=<?= $m['id'] ?>" onclick="return confirm('Voulez-vous vraiment ban ce compte?')">Ban</a></span> 
                            <?php } else {?>
                                <span class="cardArticleMainText"><a href="Admin.php?type=membre&supprime=<?= $m['id'] ?>" onclick="return confirm('Voulez-vous vraiment deban ce compte?')">Deban</a> </span> 
                            <?php } ?> 
                        <?php } ?>
                    </div>
                <?php } ?>
            </div>
            -->
        <?php } ?>
    </div>

    <div class="articleGalleryPageContainer hcenter vcenter">
            <?php for($i=1;$i<=$pagesTotales;$i++) {
                if($i == $pageCourante) {
                    echo '<a class="selected articleGalleryPageElement">'.$i.' </a>';
                } else {
                    echo '<a class="articleGalleryPageElement" href="Admin.php?page='.$i.'">'.$i.'</a>';
                }
            }?>
        </div>
</div>

<div class="right"></div>
<?php 
// Le bas de l'interface est ajouté après le contenu
include 'tmpl_bottom.php'; 
?>

<!--Application des fichiers css exclusifs-->
<link type="text/css" href="style\articles.css" rel="stylesheet">
