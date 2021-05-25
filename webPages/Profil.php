<?php
include 'tmpl_top.php'; 
$bdd = new PDO("mysql:host=127.0.0.1;dbname=espace_membre;charset=utf8", "root", "");

if(empty($_SESSION['id'])) {
    header("Location: Connexion.php");
}

if(isset($_GET['id']) AND $_GET['id'] > 0) {
    $getid = intval($_GET['id']);
    $requser = $bdd->prepare('SELECT * FROM membres WHERE id = ?');
    $requser->execute(array($getid));
    $userinfos = $requser->fetch();


?>

            <div class="left">
                <div class="navElement"><a href="Rap.php">Rap</a></div>
                <div class="navElement"><a href="MusiqueUrbaine.php">Musique Urbaine</a></div>
                <div class="navElement"><a href="ChroniquesJason.php">Les Chroniques de Jason</a></div>
            </div>

            <!--Début de là où on pourra mettre du texte-->
            <div class="middle">
                <article>
                    <div align="center">
                        <h1>
                            Profil de
                            <?php echo $userinfos['pseudo']; ?>
                        </h1>
                        <br />
                        <?php
                        if(!empty($userinfos['avatar'])) {
                        ?>
                            <img src="membres/avatars/<?php echo $userinfos['avatar']; ?>" width="150">
                            <?php
                        }
                        ?>
                                <br /><br />Pseudo =
                                <?php echo $userinfos['pseudo']; ?>
                                <br /> Email =
                                <?php echo $userinfos['adresse_email']; ?>
                                <br />
                                <?php
                        if(isset($_SESSION['id']) AND $userinfos['id'] == $_SESSION['id']) {
                        ?>
                                    <a href="editionprofil.php">Editer mon profil</a><br />
                                    <a href="Déconnexion.php">Se déconnecter</a>
                                    <?php } ?>

                    </div>


                </article>
            </div>

            <div class="right"></div>

<?php
}
// Le bas de l'interface est ajouté après le contenu
include 'tmpl_bottom.php'; 
?>
