<!--Page d'inscription en tant que membre-->

<!--Partie php = atteindre base de donnée + récupère infos formulaire, vérifie si tout est bien rempli, si pseudo et email existe pas
    déjà et transmet à base de donnée-->
<?php
$bdd = new PDO("mysql:host=127.0.0.1;dbname=inflow;charset=utf8", "root", "");
$membres2 = $bdd->query('SELECT * FROM membres');
$m = $membres2->fetch();

if(isset($_POST["forminscription"])) {

    $pseudo = htmlspecialchars($_POST['pseudo']);
    $email = htmlspecialchars($_POST['email']);
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
                            $insertmbr = $bdd->prepare("INSERT INTO membres(pseudo, mot_de_passe, adresse_email, avatar) VALUES(?, ?, ?, ?)");
                            $insertmbr->execute(array($pseudo, $pass, $email, "global/Inflow_logo.png"));
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
            <!--Début de là où on pourra mettre du texte-->
            <div class="middle">
                <article>
                    <!--Formulaire à remplir pour s'inscrire-->
                    <div align="center">
                        <h1>Inscription</h1>
                        <br /><br />
                        <form method="POST" action="">
                            <table>
                                <tr>
                                    <td align="right">
                                        <label for="pseudo">Identifiant :</label>
                                    </td>
                                    <td>
                                        <input type="text" name="pseudo" id="pseudo" maxlength="30" placeholder="30 caractères max" value="<?php if(isset($pseudo)) { echo $pseudo; } ?>" required />
                                    </td>
                                </tr>
                                <tr>
                                    <td align="right">
                                        <label for="pass"> Mot de passe :</label>
                                    </td>
                                    <td>
                                        <input type="password" name="pass" id="pass" required />
                                    </td>
                                </tr>
                                <tr>
                                    <td align="right">
                                        <label for="cpass"> Confirmer Mot de passe :</label>
                                    </td>
                                    <td>
                                        <input type="password" name="cpass" id="cpass" required />
                                    </td>
                                </tr>
                                <tr>
                                    <td align="right">
                                        <label for="email"> Adresse Email :</label>
                                    </td>
                                    <td>
                                        <input type="email" id="email" name="email" value="<?php if(isset($email)) { echo $email; } ?>" required />
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                    </td>
                                    <td align="center">
                                        <br />
                                        <input type="submit" name="forminscription" value="Envoyer" />
                                    </td>
                                </tr>
                            </table>
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
