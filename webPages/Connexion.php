<!--Page d'inscription en tant que membre-->

<!--Partie php = atteindre base de donnée + récupère infos formulaire, vérifie si tout est bien rempli, si pseudo et email existe pas
    déjà et transmet à base de donnée-->
<?php
session_start();
$bdd = new PDO("mysql:host=127.0.0.1;dbname=inflow;charset=utf8", "root", "");

if(isset($_POST["formconnexion"])) {
    $pseudoconnect = htmlspecialchars($_POST["pseudoconnect"]);
    $passconnect = sha1($_POST['passconnect']);
    if(!empty($pseudoconnect) AND !empty($passconnect)) {
        $requser = $bdd->prepare('SELECT * FROM membres WHERE pseudo = ? AND mot_de_passe = ?');
        $requser->execute(array($pseudoconnect, $passconnect));
        $userexist = $requser->rowCount();
        if($userexist == 1) {
            if(empty($_SESSION)) {
                $userinfos = $requser->fetch();
                $_SESSION['id'] = $userinfos['id'];
                $_SESSION['pseudo'] = $userinfos['pseudo'];
                $_SESSION['adresse_email'] = $userinfos['adresse_email'];
                $_SESSION['redacteur'] = $userinfos['redacteur'];
                $_SESSION['admin'] = $userinfos['admin'];
                $_SESSION['avatar'] = $userinfos['avatar'];
                header("Location: Profil.php?id=".$_SESSION['id']);
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
            include 'LEFT/begin.php';
            include 'LEFT/categories.php';
            include 'LEFT/end.php';
            ?>
            <!--Début de là où on pourra mettre du texte-->
            <div class="middle">
                <article>
                    <!--Formulaire à remplir pour s'inscrire-->
                    <div align="center">
                        <h1>Connexion</h1>
                        <br /><br />
                        <form method="POST" action="">
                            <input type="text" name="pseudoconnect" placeholder="Identifiant" />
                            <input type="password" name="passconnect" placeholder="Mot de Passe" />
                            <input type="submit" name="formconnexion" value="Se connecter" />
                        </form>
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
