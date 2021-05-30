<?php
session_start();
$bdd = new PDO("mysql:host=127.0.0.1;dbname=espace_membre;charset=utf8", "root", "");

if(isset($_SESSION['id'])) {
    $requeser = $bdd->prepare("SELECT * FROM membres WHERE id = ?");
    $requeser->execute(array($_SESSION['id']));
    $user = $requeser->fetch();

    if(isset($_POST['newpseudo']) AND !empty($_POST['newpseudo']) AND $_POST['newpseudo'] != $user['pseudo']) {
        $newpseudo = htmlspecialchars($_POST['newpseudo']);
        $pseudolenght = strlen($newpseudo);
        if($pseudolenght <= 255) {
            $reqpseudo = $bdd->prepare('SELECT * FROM membres WHERE pseudo = ?');
            $reqpseudo->execute(array($newpseudo));
            $pseudoexist = $reqpseudo->rowCount();
            if($pseudoexist == 0) {
                $insertpseudo = $bdd->prepare("UPDATE membres SET pseudo = ? WHERE id = ?");
                $insertpseudo->execute(array($newpseudo, $_SESSION['id']));
                header("Location: Profil.php?id=".$_SESSION['id']);
            } else {
                $erreur = "Cet identifiant existe déjà !!!";
            }
        }
    }
    if(isset($_POST['newemail']) AND !empty($_POST['newemail']) AND $_POST['newemail'] != $user['adresse_email']) {
        $newemail = htmlspecialchars($_POST['newemail']);
        if(filter_var($newemail, FILTER_VALIDATE_EMAIL)) {
            $reqemail = $bdd->prepare('SELECT * FROM membres WHERE adresse_email = ?');
            $reqemail->execute(array($newemail));
            $emailexist = $reqemail->rowCount();
            if($emailexist == 0) {
                $newemail = htmlspecialchars($_POST['newemail']);
                $insertemail = $bdd->prepare("UPDATE membres SET adresse_email = ? WHERE id = ?");
                $insertemail->execute(array($newemail, $_SESSION['id']));
                header("Location: Profil.php?id=".$_SESSION['id']);
            }
        }
    }
    if(isset($_POST['newpass']) AND !empty($_POST['newpass']) AND isset($_POST['newpass2']) AND !empty($_POST['newpass2'])) {

        $pass = sha1($_POST['newpass']);
        $pass2 = sha1($_POST['newpass2']);

        if($pass == $pass2) {
            $insertpass = $bdd->prepare("UPDATE membres SET mot_de_passe = ? WHERE id = ?");
            $insertpass->execute(array($pass, $_SESSION['id']));
            header("Location: Profil.php?id=".$_SESSION['id']);
        } else {
            $erreur = "Vos mots de passe ne correspondent pas ";
        }
    }

    if(isset($_FILES['avatar']) AND !empty($_FILES['avatar']['name'])) {
        $tailleMax = 5242880;
        $extensionValides = array('jpg', 'png', 'jpeg', 'gif');
        if($_FILES['avatar']['size'] <= $tailleMax) {
            $extensionUpload = strtolower(substr(strrchr($_FILES['avatar']['name'], '.'), 1));
            if(in_array($extensionUpload, $extensionValides)) {
                $chemin = "membres/avatars/".$_SESSION['id'].".".$extensionUpload;
                $resultat = move_uploaded_file($_FILES['avatar']['tmp_name'], $chemin);
                if($resultat) {
                    $updateAvatar = $bdd->prepare("UPDATE membres SET avatar = :avatar WHERE id = :id");
                    $updateAvatar->execute(array(
                        'avatar' => $_SESSION['id'].".".$extensionUpload,
                        'id' => $_SESSION['id']
                        ));
                    header("Location: Profil.php?id=".$_SESSION['id']);
                } else {
                    $erreur = "Il y a une erreur lors de l'importation de votre fichier";
                }
            } else {
                $erreur = "Ce format d'image n'est pas valide";
            }
        } else {
            $erreur = "Cette image en impose trop (5Mo max)";
        }
    }

    if(isset($_POST['newpseudo']) AND $_POST['newpseudo'] == $user['pseudo']) {
        header("Location: Profil.php?id=".$_SESSION['id']);
    }

    include 'tmpl_top.php'; 
?>
            <div class="left">
                <div class="navElement"><a href="tmpl_catégories.php?id=3">Rap</a></div>
                <div class="navElement"><a href="tmpl_catégories.php?id=2">Musique Urbaine</a></div>
                <div class="navElement"><a href="tmpl_catégories.php?id=1">Les Chroniques de Jason</a></div>
            </div>

            <!--Début de là où on pourra mettre du texte-->
            <div class="middle">
                <article>
                    <div align="center">
                        <h1>Edition de mon profil</h1>
                        <form method="POST" action="" enctype="multipart/form-data">
                            <table>
                                <tr>
                                    <td align="right">
                                        <label for="newpseudo">Identifiant :</label>
                                    </td>
                                    <td>
                                        <input type="text" name="newpseudo" id="newpseudo" maxlength="30" placeholder="Mot de passe" value="<?php echo $user['pseudo']; ?>" />
                                    </td>
                                </tr>
                                <tr>
                                    <td align="right">
                                        <label for="newpass"> Mot de passe :</label>
                                    </td>
                                    <td>
                                        <input type="password" name="newpass" id="newpass" />
                                    </td>
                                </tr>
                                <tr>
                                    <td align="right">
                                        <label for="newpass2"> Confirmer Mot de passe :</label>
                                    </td>
                                    <td>
                                        <input type="password" name="newpass2" id="newpass2" />
                                    </td>
                                </tr>
                                <tr>
                                    <td align="right">
                                        <label for="newemail"> Adresse Email :</label>
                                    </td>
                                    <td>
                                        <input type="email" id="newemail" name="newemail" value="<?php echo $user['adresse_email']; ?>" />
                                    </td>
                                </tr>
                                <tr>
                                    <td align="right">
                                        <label>Avatar :</label>
                                    </td>
                                    <td>
                                        <input type="file" name="avatar" />
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                    </td>
                                    <td align="center">
                                        <br />
                                        <input type="submit" value="Mise à jour" />
                                    </td>
                                </tr>
                            </table>
                        </form>
                        <?php if(isset($erreur)) { echo $erreur; } ?>
                    </div>

                </article>
            </div>

            <div class="right"></div>


<?php
} else {
    header("Location: Connexion.php");
}
// Le bas de l'interface est ajouté après le contenu
include 'tmpl_bottom.php'; 
?>
