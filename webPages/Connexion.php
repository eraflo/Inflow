<!--Page d'inscription en tant que membre-->

<!--Partie php = atteindre base de donnée + récupère infos formulaire, vérifie si tout est bien rempli, si pseudo et email existe pas
    déjà et transmet à base de donnée-->
<?php
session_start();
$bdd = new PDO("mysql:host=127.0.0.1;dbname=inflow;charset=utf8", "root", "");

include 'stats_visites_site.php';

if(isset($_POST["formconnexion"])) {
    $pseudoconnect = htmlspecialchars($_POST["pseudoconnect"]);
    $passconnect = sha1($_POST['passconnect']);
    if(!empty($pseudoconnect) AND !empty($passconnect)) {
        $requser = $bdd->prepare('SELECT * FROM membres WHERE pseudo = ? AND mot_de_passe = ?');
        $requser->execute(array($pseudoconnect, $passconnect));
        $userexist = $requser->rowCount();
        if($userexist == 1) {
            if(empty($_SESSION) || (!isset($_SESSION['id']))) {
                $userinfos = $requser->fetch();
                if($userinfos['actif'] == 0) {
                    $_SESSION['id'] = $userinfos['id'];
                    $_SESSION['pseudo'] = $userinfos['pseudo'];
                    $_SESSION['adresse_email'] = $userinfos['adresse_email'];
                    $_SESSION['redacteur'] = $userinfos['redacteur'];
                    $_SESSION['admin'] = $userinfos['admin'];
                    $_SESSION['avatar'] = $userinfos['avatar'];
                    header("Location: Parametres.php"); // permet sycronisation des parametres
                    // header("Location: Profil.php?id=".$_SESSION['id']);
                } else {
                    $erreur = "Vous êtes bannis, contactez les admins !";
                }
            } else {
                $erreur = "Vous êtes déjà connecté";
            }
        } else {
            $erreur = "Identifiant ou mot de passe erroné";
        }
    } else {
        $erreur = "Tous les champs ne sont pas remplis.";
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
                        <p class="Titre_form">Connexion</p>
                        <input class="input_form" type="text" name="pseudoconnect" placeholder="Identifiant" /></br>
                        <input id="password_input" class="input_form" type="password" name="passconnect" placeholder="Mot de Passe"></img>
                        <img id="password_visibility" class="visibility_button" src="assets/afficher.png" width="24px" /></br>
                        <input class="input_form" type="submit" name="formconnexion" value="Se connecter" /></br>
                        <a href="recuperation.php" class="Oublie">Mot de passe oublié</a>
                    </form>

                    <!--Ombres-->
                    <div class="drop_drop" id="drop_1"></div>
                    <div class="drop_drop" id="drop_2"></div>
                    <div class="drop_drop" id="drop_3"></div>
                    <div class="drop_drop" id="drop_4">Pas encore inscrit ?<a href="Inscription.php">C'est par ici</a></div>
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
