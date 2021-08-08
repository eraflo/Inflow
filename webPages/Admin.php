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
    if(isset($_GET['supp']) AND !empty($_GET['supp'])) {
        $id_supp = (int) $_GET['supp'];
        $del_profil = $bdd->prepare('DELETE FROM membres WHERE id = ?');
        $del_profil->execute(array($id_supp));
        $del_com = $bdd->prepare('DELETE FROM commentaires WHERE id_pseudo = ?');
        $del_com->execute(array($id_supp));
        $del_lien = $bdd->prepare('DELETE FROM liens_sociaux WHERE id_membre = ?');
        $del_lien->execute(array($id_supp));
    }
}

if(isset($_GET['type']) AND $_GET['type'] == 'membre') {
    if(isset($_GET['ban_deban']) AND !empty($_GET['ban_deban'])) {
        $actif = (int) $_GET['ban_deban'];
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
    <div class="cardGallery hcenter">
        <?php while($m = $membres->fetch()) { ?>
        <div class="profil">
            <a href="Profil.php?id=<?= $m['id'] ?>" class=""
                title="<?= $m['pseudo']?>    ID : <?= $m['id'] ?>">
                <div class="cardArticle">
                    <img style="width:300%" class="" src="membres/avatars/<?php echo $m['avatar']; ?>" loading="lazy" />
                </div>
            </a>
            <div class="container">
                <?php if(($m['admin'] == 0) OR ($m['redacteur'] == 0)) { ?>
                <div class="drop_drop" id="drop_6">
                    <?php if(($m['admin'] == 0) OR ($m['redacteur'] == 0)) { ?>
                    <?php if($m['admin'] == 0) { ?><a href="Admin.php?type=membre&admin=<?= $m['id'] ?>"
                        onclick="return confirm('Voulez-vous vraiment le rendre admin?')"><img
                            src="assets/admin.png"></a><?php } ?>
                    <?php if($m['redacteur'] == 0) { ?><a href="Admin.php?type=membre&redacteur=<?= $m['id'] ?>"
                        onclick="return confirm('Voulez-vous vraiment le rendre rédacteur?')"><img
                            src="assets/rédacteur.png"></a><?php } ?>
                    <?php if($m['admin'] == 0) { ?><a href="Admin.php?type=membre&supp=<?= $m['id'] ?>"
                        onclick="return confirm('Voulez-vous vraiment supprimer ce compte?')"><img
                            src="assets/delete.png"></a><?php } ?>
                    <?php if($m['admin'] == 0) { ?>
                    <?php if($m['actif'] == 0) { ?>
                    <a href="Admin.php?type=membre&ban_deban=<?= $m['id'] ?>"
                        onclick="return confirm('Voulez-vous vraiment ban ce compte?')"><img src="assets/ban.png"></a>
                    <?php } else {?>
                    <a href="Admin.php?type=membre&ban_deban=<?= $m['id'] ?>"
                        onclick="return confirm('Voulez-vous vraiment deban ce compte?')"><img
                            src="assets/deban.png"></a>
                    <?php } ?>
                    <?php } ?>
                    <?php } ?>
                </div>
                <?php } ?>
            </div>
        </div>
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
<link type="text/css" href="style\admin.css" rel="stylesheet">