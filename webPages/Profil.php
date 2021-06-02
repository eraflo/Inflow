<?php
session_start();
$bdd = new PDO("mysql:host=127.0.0.1;dbname=inflow;charset=utf8", "root", "");


if(isset($_GET['id']) AND $_GET['id'] > 0) {
    $getid = intval($_GET['id']);
    $requser = $bdd->prepare('SELECT * FROM membres WHERE id = ?');
    $requser->execute(array($getid));
    $userinfos = $requser->fetch();
    $req_articles = $bdd->prepare('SELECT * FROM articles WHERE id_auteur = ? ORDER BY date_time_publication DESC');
    $req_articles->execute(array($userinfos['id']));
    include 'tmpl_top.php';
    ?>
            <?php
            include 'LEFT/begin.php';
            include 'LEFT/categories.php';
            include 'LEFT/end.php';
            ?>

            

            <!--Début de là où on pourra mettre du texte-->
            <div class="middle ProfilTxt">
                <h1><div class="PName">
                    Profil de
                    <?php echo $userinfos['pseudo']; ?>
                </div>
                </h1>

                <div class="PTitle">
                    <br /><u>Informations Utilisateur</u>
                </div>

                <?php
                if(!empty($userinfos['avatar'])) {
                ?>
                    <img src="membres/avatars/<?php echo $userinfos['avatar']; ?>" class="avatar" width="150">
                    <?php
                }
                ?>
                        <br /><g>Pseudonyme:</g><br />
                        <div class="PCapsule">
                            <?php echo $userinfos['pseudo']; ?>
                        </div>
                        <br /><g>Adresse Email:</g>
                        <div class="PCapsule">
                            <?php echo $userinfos['adresse_email']; ?>
                        </div>
                        <br />
                <?php if(isset($_SESSION['id']) AND $userinfos['id'] == $_SESSION['id']) { ?>
                    <div class="PTitle">
                            <br /><u>Actions Utilisateur<br /></u>
                    </div>
                    <a href="editionprofil.php"><div class="PActions">. <i>Editer mon profil </i></div></a><br />
                    <a href="Déconnexion.php"><div class="PActions">. <i>Se déconnecter</i></div></a>
                <?php } ?>
                <br/>
                <br/>
                <?php if ($req_articles->rowCount() > 0) { ?>
                    <div class="PTitle"><u>Articles écris</u></div>
                    <?php while($u = $req_articles->fetch()) { ?>
                        <a href="Publication.php?id=<?= $u['id'] ?>"> <div class="PActions"><i>-  <?= $u['titre'] ?></i></div></a>
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
