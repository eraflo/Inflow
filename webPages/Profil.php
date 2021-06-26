<?php
session_start();
$bdd = new PDO("mysql:host=127.0.0.1;dbname=inflow;charset=utf8", "root", "");

include 'stats_visites_site.php';

if(isset($_GET['id']) AND $_GET['id'] > 0) {
    $getid = intval($_GET['id']);
    $requser = $bdd->prepare('SELECT * FROM membres WHERE id = ?');
    $requser->execute(array($getid));
    $userinfos = $requser->fetch();
    $req_articles = $bdd->prepare('SELECT * FROM articles WHERE id_auteur = ? ORDER BY date_time_publication DESC');
    $req_articles->execute(array($userinfos['id']));
    $req_liens = $bdd->prepare('SELECT * FROM `liens_sociaux` WHERE id_membre = ?');
    $req_liens->execute(array($userinfos['id']));

    include 'tmpl_top.php';
    ?>
    <?php
    include 'MODULES/begin_left.php';
    include 'MODULES/categories.php';
    include 'MODULES/end.php';
    ?>

    <!--Début de là où on pourra mettre du texte-->
    <div class="middle ProfilTxt">
        <h1><div class="PName">
            Profil de
            <?php echo $userinfos['pseudo']; ?>
        </div>
        </h1>

        <div class="PTitle">
            <br />Informations Utilisateur
        </div>

        <?php if(!empty($userinfos['avatar'])) { ?>
            <img src="membres/avatars/<?php echo $userinfos['avatar']; ?>" class="avatar" width="150" style="margin:5px;">
        <?php } ?>
                <br /><b>Pseudonyme:</b><br />
                <div class="PCapsule">
                    <?php echo $userinfos['pseudo']; ?>
                </div>
                <br /><b>Adresse Email:</b>
                <div class="PCapsule">
                    <?php echo $userinfos['adresse_email']; ?>
                </div>
                
                <?php if(isset($userinfos['biographie']) AND !empty($userinfos['biographie'])) { ?>
                    <br /><b>Biographie:</b>
                    <div class="PCapsule">
                        <?php echo $userinfos['biographie']; ?>
                    </div>
                    <br />
                <?php } ?>
        <?php if(isset($_SESSION['id']) AND $userinfos['id'] == $_SESSION['id']) { ?>
            <div class="PTitle">
                    <br />Actions Utilisateur<br />
            </div>
            <a href="editionprofil.php"><div class="PActions">. <i>Editer mon profil </i></div></a><br />
            <a href="deconnexion.php"><div class="PActions">. <i>Se déconnecter</i></div></a>
        <?php } ?>
        <br/>
        <br/>
        <?php if ($req_articles->rowCount() > 0) { ?>
            <div class="PTitle">Articles écris</div>
            <?php while($u = $req_articles->fetch()) { ?>
                <a href="Publication.php?id=<?= $u['id'] ?>"> <div class="PActions"><i>-  <?= $u['titre'] ?></i></div></a>
                <br/>
            <?php }
        } ?>
        <br/>
        <?php if ($req_liens->rowCount() > 0) { ?>
            <div class="PTitle">Liens</div>
            <?php while($l = $req_liens->fetch()) { ?>
                <img src="https://www.google.com/s2/favicons?domain=<?= $l['nom'] ?>" height="16" />
                <a href="<?= $l['url'] ?>" rel="noreferrer noopener"><div class="PActions"><?= $l['nom'] ?></div></a>
                <br/>
            <?php }
        } ?>
    </div>

    <div class="right"></div>

<?php
}
// Le bas de l'interface est ajouté après le contenu
include 'tmpl_bottom.php'; 
?>

<!--Application des fichiers css exclusifs-->
<link type="text/css" href="style\profil.css" rel="stylesheet">
