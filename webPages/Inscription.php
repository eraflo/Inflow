<!--Page d'inscription en tant que membre-->

<!--Partie php = atteindre base de donnée + récupère infos formulaire, vérifie si tout est bien rempli, si pseudo et email existe pas
    déjà et transmet à base de donnée-->
<?php
$bdd = new PDO("mysql:host=127.0.0.1;dbname=inflow;charset=utf8", "root", "");
include('filtre.php');
$membres2 = $bdd->query('SELECT * FROM membres');
$m = $membres2->fetch();

include 'stats_visites_site.php';

if(isset($_POST["forminscription"])) {

    $pseudo = htmlspecialchars($_POST['pseudo']);
    $email = htmlspecialchars($_POST['email']);
    $biographie = htmlspecialchars($_POST['bio']);
    $pass = sha1($_POST['pass']);
    $cpass = sha1($_POST['cpass']);

    if(!empty($_POST['pseudo']) AND !empty($_POST['pass']) AND !empty($_POST['cpass']) AND !empty($_POST['email'])) {

        $pseudolenght = strlen($pseudo);

        if($pseudolenght <= 255) {
            if(filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $reqemail = $bdd->prepare('SELECT * FROM membres WHERE adresse_email = ?');
                $reqemail->execute(array($email));
                $emailexist = $reqemail->rowCount();
                if($emailexist == 0) {
                    $reqpseudo = $bdd->prepare('SELECT * FROM membres WHERE pseudo = ?');
                    $reqpseudo->execute(array($pseudo));
                    $pseudoexist = $reqpseudo->rowCount();
                    if($pseudoexist == 0) {
                        if($pass == $cpass) {
                            $insertmbr = $bdd->prepare("INSERT INTO membres(pseudo, mot_de_passe, adresse_email, biographie, avatar) VALUES(?, ?, ?, ?, ?)");
                            $insertmbr->execute(array($pseudo, $pass, $email, Filtre($biographie), "global/Inflow_logo.png"));
                            $erreur = "Votre compte a été créé !!!";
                        } else {
                            $erreur = "Les mots de passe sont différents";
                        }
                    } else {
                        $erreur = "Ce pseudo existe déjà !";
                    }
                } else {
                    $erreur = "Cette email existe déjà !";
                }
            } else {
                $erreur = "Pas une adresse email !!!";
            }
        } else {
            $erreur = "Votre identifiant est trop long !";
        }
    } else {
        $erreur = "Remplissez tous les champs !!!";
    }
}
include 'tmpl_top.php';
?>
<?php
include 'MODULES/begin_left.php';
include 'MODULES/end.php';
?>
<!--Début de là où on pourra mettre du texte-->
<div class="middle">
    <article>
        <!--Formulaire à remplir pour s'inscrire-->
        <div class="form_con_ins">
            <div class="container">
                <!--Formulaire-->
                <form class="con_ins" method="POST" action="" enctype="multipart/form-data">
                    <p class="Titre_form">Inscription</p>
                    <input class="input_form" type="text" name="pseudo" id="pseudo" maxlength="30"
                        placeholder=" Pseudo : 30 caractères max" value="<?php if(isset($pseudo)) { echo $pseudo; } ?>"
                        required /></br>
                    <input class="input_form" type="email" placeholder="Email" id="email" name="email"
                        value="<?php if(isset($email)) { echo $email; } ?>" required /></br>
                    <input id="password_input" class="input_form" type="password" placeholder="Mot de passe" name="pass"
                        id="pass" required />
                    <img id="password_visibility" class="visibility_button" src="assets/afficher.png" width="24px" /></br>
                    <input class="input_form" type="password" placeholder="Confirmer mdp" name="cpass" id="cpass"
                        required /></br>
                    <input class="input_form" type="text" name="bio" id="bio" placeholder="Petite Bio sur vous"
                        required /></br>
                    <input class="input_form" type="submit" name="forminscription" value="Envoyer" />
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
<link type="text/css" href="style\inscription-connexion.css" rel="stylesheet">
<script src="JS/inscription-connexion.js" defer></script>