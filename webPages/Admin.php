<!--Page pour les admins, à améliorer pour gérer commentaires, articles, connexion...-->
<!--Connecte à base de données + début gérer accès membres-->
<?php
include 'tmpl_top.php'; 
$bdd = new PDO("mysql:host=127.0.0.1;dbname=espace_membre;charset=utf8", "root", "");

if(!isset($_SESSION['admin']) OR $_SESSION['admin'] != 1 OR !isset($_SESSION)) {
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
    if(isset($_GET['confirmer']) AND !empty($_GET['confirmer'])) {

        $confirmer = (int) $_GET['confirmer'];
        $req = $bdd->prepare('UPDATE membres SET confirmer = 1 WHERE id = ?');
        $req->execute(array($confirmer));
        $nconf = $bdd->query('SELECT * FROM membres');
        $newconf = $nconf->fetch();
        $_SESSION['confirmer'] = $newconf['confirmer'];
    }
}

if(isset($_GET['supprime']) AND !empty($_GET['supprime'])) {
    $supprime = (int) $_GET['supprime'];
    $req = $bdd->prepare('DELETE FROM membres WHERE id = ?');
    $req->execute(array($supprime));
}

$membres = $bdd->query('SELECT * FROM membres ORDER BY id DESC');

?>
            <div class="left">
                <div class="navElement"><a href="Rap.php">Rap</a></div>
                <div class="navElement"><a href="MusiqueUrbaine.php">Musique Urbaine</a></div>
                <div class="navElement"><a href="ChroniquesJason.php">Les Chroniques de Jason</a></div>
            </div>

            <!--Début de là où on pourra mettre du texte-->
            <div class="middle">
                <ul>
                    <?php while($m = $membres->fetch()) { ?>
                    <li>
                        <?= $m['id'] ?> :
                            <?= $m['pseudo'] ?>
                                <?php if($m['admin'] == 0) { ?> - <a href="Admin.php?type=membre&admin=<?= $m['id'] ?>">Admin</a>
                                <?php } ?>
                                <?php if($m['confirmer'] == 0) { ?> - <a href="Admin.php?type=membre&confirmer=<?= $m['id'] ?>">Rédacteur</a>
                                <?php } ?>
                                <?php if($m['admin'] == 0) { ?> - <a href="Admin.php?type=membre&supprime=<?= $m['id'] ?>">Supprimer</a>
                                <?php } ?>
                    </li>
                    <?php } ?>
                </ul>
            </div>

            <div class="right"></div>
<?php 
// Le bas de l'interface est ajouté après le contenu
include 'tmpl_bottom.php'; 
?>
