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
            <div class="middle">
                <article>
<<<<<<< Updated upstream
                    <div align="center">
                        <h1>
                            Profil de
                            <?php echo $userinfos['pseudo']; ?>
                        </h1>
                        <?php
                        if(!empty($userinfos['avatar'])) {
                        ?>
                            <img src="membres/avatars/<?php echo $userinfos['avatar']; ?>" class="avatar" width="150">
                            <?php
                        }
                        ?>
                                <br /><br />Pseudo =
                                <?php echo $userinfos['pseudo']; ?>
                                <br /> Email =
                                <?php echo $userinfos['adresse_email']; ?>
                                <br />
                        <?php if(isset($_SESSION['id']) AND $userinfos['id'] == $_SESSION['id']) { ?>
                            <a href="editionprofil.php">Editer mon profil</a><br />
                            <a href="Déconnexion.php">Se déconnecter</a>
                        <?php } ?>
                        <br/>
                        <br/>
                        <?php if ($req_articles->rowCount() > 0) { ?>
                            <h2><b>Articles écris</b></h2>
                            <?php while($u = $req_articles->fetch()) { ?>
                                <a href="Publication.php?id=<?= $u['id'] ?>" ><?= $u['titre'] ?></a>
                                <br/>
                            <?php }
                        } ?>

                    </div>

=======
                    <div class="PName">
                        <h1><g>
                            Profil de
                            <?php echo $userinfos['pseudo']; ?>
                        </g>
                        </h1>
                    </div>

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
                            <div class="PTitle">
                                <br /><u>Actions Utilisateur<br /></u>
                            </div>
                    <?php if(isset($_SESSION['id']) AND $userinfos['id'] == $_SESSION['id']) { ?>
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
>>>>>>> Stashed changes

                </article>
            </div>

            <div class="right"></div>

<?php
}
// Le bas de l'interface est ajouté après le contenu
include 'tmpl_bottom.php'; 
?>
