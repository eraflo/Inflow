<?php
session_start();
$bdd = new PDO("mysql:host=127.0.0.1;dbname=inflow;charset=utf8", "root", "");

if(isset($_GET['section'])) {
    $section = htmlspecialchars($_GET['section']);
} else {
    $section = "";
}

if(isset($_POST['recup_submit'], $_POST['recup_mail'])) {
    if(!empty($_POST['recup_mail'])) {
        $recup_mail = htmlspecialchars($_POST['recup_mail']);
        if(filter_var($recup_mail, FILTER_VALIDATE_EMAIL)) {
            $mail_exist = $bdd->prepare('SELECT id, pseudo FROM membres WHERE adresse_email = ?');
            $mail_exist->execute(array($recup_mail));
            $mail_exist_count = $mail_exist->rowCount();
            if($mail_exist_count == 1) {
                $pseudo = $mail_exist->fetch();
                $pseudo = $pseudo['pseudo'];
                $recup_code = "";
                for($i =0; $i < 8; $i++) {
                    $recup_code .= mt_rand(0, 9);
                }

                $mail_recup_exist = $bdd->prepare('SELECT id FROM recuperation WHERE mail = ?');
                $mail_recup_exist->execute(array($recup_mail));
                $mail_recup_exist = $mail_recup_exist->rowCount();

                if($mail_recup_exist == 1) {
                    $recup_insert = $bdd->prepare('UPDATE recuperation SET code = ? WHERE mail = ?');
                    $recup_insert->execute(array($recup_code, $recup_mail));
                } else {
                    $recup_insert = $bdd->prepare('INSERT INTO recuperation(mail, code) VALUES (?, ?)');
                    $recup_insert->execute(array($recup_mail, $recup_code));
                }

                include 'message_mail.php';
            } else {
                $erreur = "Cette adresse email n'existe pas";
            }
        } else {
            $erreur = "Cette adresse email n'est pas valide";
        }
    } else {
        $erreur = "Veuillez entrer un email !";
    }
}

if(isset($_POST['verif_submit'], $_POST['verif_code'])) {
    if(!empty($_POST['verif_code'])) {
        $verif_code = htmlspecialchars($_POST['verif_code']);
        $verif_req = $bdd->prepare('SELECT id FROM recuperation WHERE mail = ? AND code = ?');
        $verif_req->execute(array($_GET['rm'], $verif_code));
        $verif_req = $verif_req->rowCount();
        if($verif_req == 1) {
            $up_req = $bdd->prepare('UPDATE recuperation SET confirme = 1 WHERE mail = ?');
            $up_req->execute(array($_GET['rm']));
            header("Location: http://88.163.212.206:49160/webPages/recuperation.php?section=changemdp&rm=".$_GET['rm']."");
        } else {
            $erreur = "Code invalide";
        }
    } else {
        $erreur = "Entrez le code de réinitialisation";
    }
}

if(isset($_POST['change_submit'])) {
    if(isset($_POST['change_mdp'], $_POST['change_mdpc'])) {
        $verif_confirme = $bdd->prepare('SELECT confirme FROM recuperation WHERE mail = ?');
        $verif_confirme->execute(array($_GET['rm']));
        $verif_confirme = $verif_confirme->fetch();
        $verif_confirme = $verif_confirme['confirme'];
        if($verif_confirme == 1) {
            $mdp = htmlspecialchars($_POST['change_mdp']);
            $mdpc = htmlspecialchars($_POST['change_mdpc']);
            if(!empty($mdp) AND !empty($mdpc)) {
                if($mdp == $mdpc) {
                    $mdp = sha1($mdp);
                    $ins_mdp = $bdd->prepare('UPDATE membres SET mot_de_passe = ? WHERE adresse_email = ?');
                    $ins_mdp->execute(array($mdp, $_GET['rm']));
                    $del_req = $bdd->prepare('DELETE FROM recuperation WHERE mail = ?');
                    $del_req->execute(array($_GET['rm']));
                    header("Location: Connexion.php");
                } else {
                    $erreur = "Les mots de passe ne correspondent pas";
                }
            } else {
                $erreur = "Veuillez remplir tous les champs";
            }
        } else {
            $erreur = "Petit intru, arrête de fouiner !!!";
        }
    } else {
        $erreur = "Veuillez remplir les deux champs";
    }
}

include 'tmpl_top.php';
?>
<?php
include 'MODULES/begin_left.php';
include 'MODULES/categories.php';
include 'MODULES/end.php';
?>

<!--Début de là où on pourra mettre du texte-->
<div class="middle">
    <article>
        <!--Formulaire à remplir pour s'inscrire-->
        <div align="center">
            <div class="form_con_ins">
                <div class="container">
                    <!--Formulaire-->
                    <form class="con_ins" method="POST" action="" enctype="multipart/form-data">
                        <?php if($section == 'code') { ?>
                            <p class="Titre_form">Récupération mot de passe - Code de réinitialisation envoyé à <?= $_GET['rm'] ?></p>
                            <input class="input_form" type="text" placeholder="Code de vérification" name="verif_code" /></br>
                            <input class="input_form" type="submit" value="Valider" name="verif_submit" /></br>
                        <?php } elseif($section == 'changemdp') { ?>
                            <p class="Titre_form">Nouveau mot de passe pour <?= $_GET['rm'] ?></p>
                            <input class="input_form" type="password" placeholder="Nouveau mot de passe" name="change_mdp" required /></br>
                            <input class="input_form" type="password" placeholder="Confirmer mdp" name="change_mdpc" required /></br>
                            <input class="input_form" type="submit" value="Valider" name="change_submit" /></br>
                        <?php } else { ?>
                            <p class="Titre_form">Récupération mot de passe</p>
                            <input class="input_form" type="email" placeholder="Email" name="recup_mail" /></br>
                            <input class="input_form" type="submit" value="Valider" name="recup_submit" /></br>
                        <?php } ?>
                    </form>

                    <!--Ombres-->
                    <div class="drop_drop" id="drop_1"></div>
                    <div class="drop_drop" id="drop_2"></div>
                    <div class="drop_drop" id="drop_3"></div>
                    <div class="drop_drop" id="drop_4"></div>
                    <div class="drop_drop" id="drop_5"></div>
                </div>
            </div>

            <!--Affiche message si erreur ou si compte bien créé-->
            <?php
            if(isset($erreur)){
            echo $erreur;
            }
            ?>
        </div>


    </article>
</div>

<div class="right"></div>

<?php
// Le bas de l'interface est ajouté après le contenu
include 'tmpl_bottom.php';
?>