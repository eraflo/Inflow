<?php
session_start();
$bdd = new PDO("mysql:host=127.0.0.1;dbname=inflow;charset=utf8", "root", "");

include 'stats_visites_site.php';
include 'webp_convert.php';

if(isset($_SESSION['id']) || $_POST['nohead'] == "true") {
    $requeser = $bdd->prepare("SELECT * FROM membres WHERE id = ?");
    $requeser->execute(array($_SESSION['id']));
    $user = $requeser->fetch();
    $req_liens = $bdd->prepare('SELECT * FROM `liens_sociaux` WHERE id_membre = ?');
    $req_liens->execute(array($user['id']));

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
    if(isset($_POST['newbio']) AND !empty($_POST['newbio']) AND $_POST['newbio'] != $user['biographie']) {
        $newbio = htmlspecialchars($_POST['newbio']);
        $insertbio = $bdd->prepare("UPDATE membres SET biographie = ? WHERE id = ?");
        $insertbio->execute(array($newbio, $_SESSION['id']));
        header("Location: Profil.php?id=".$_SESSION['id']);
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
                // Suppr les anciens avatars
                array_map('unlink', glob('membres/avatars/'.$_SESSION['id'].'.*'));

                $chemin = "membres/avatars/".$_SESSION['id'].".".$extensionUpload;
                $resultat = move_uploaded_file($_FILES['avatar']['tmp_name'], $chemin);
                generate_webp_image($chemin);
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

    if(isset($_POST['social_link']) && !empty($_POST['social_link'])) {
        $social_link = htmlspecialchars($_POST['social_link']);
        $req_check_links = $bdd->prepare("SELECT * FROM `liens_sociaux` WHERE ((id_membre = ?) AND (url = ?))");
        $req_check_links->execute(array($user['id'], $social_link));
        
        if($req_check_links->rowCount() > 0 AND (isset($_POST["social_link_delete"]) AND htmlspecialchars($_POST["social_link_delete"]) == "true")) {
            $delete_link = $bdd->prepare("DELETE FROM `liens_sociaux` WHERE (id_membre = ? AND url = ?)");
            $delete_link->execute(array($user['id'], $social_link));

            // echoes answer only if nohead is sent to the server
            if($_POST['nohead'] == "true") {
                $data = ['deleted' => $social_link];
                header('Content-Type: application/json;charset=utf-8');
                echo json_encode($data);
            }
        } elseif(filter_var($social_link, FILTER_VALIDATE_URL)) {
            
            if($req_check_links->rowCount() > 0){
                $links_mess = "error - a link with this url already exists";
                if($_POST['nohead'] == "true") {
                    echo $links_mess;
                }
            } else {
                $social_name = parse_url($social_link, PHP_URL_HOST);
                $insertlink = $bdd->prepare("INSERT INTO `liens_sociaux` (id_membre, nom, url) VALUES(?, ?, ?)");
                $insertlink->execute(array($user['id'], $social_name, $social_link));

                // echoes answer only if nohead is sent to the server
                if($_POST['nohead'] == "true") {
                    $data = ['link_name' => $social_name, 'link_url' => $social_link];
                    header('Content-Type: application/json;charset=utf-8');
                    echo json_encode($data);
                }
            }
        } else {
            $links_mess = "error - url of link could not be validated";
            if($_POST['nohead'] == "true") {
                echo $links_mess;
            }
        }
        
    }

    if(isset($_POST['social_link_modify']))

    if(isset($_POST['newpseudo']) AND $_POST['newpseudo'] == $user['pseudo']) {
        header("Location: Profil.php?id=".$_SESSION['id']);
    }

    // n'affiche pas la page quand "nohead" est envoyé au serveur
    if(!isset($_POST['nohead'])) {
        include 'tmpl_top.php'; 
?>
<!--Début de là où on pourra mettre du texte-->
<div class="middle">
    <article>
        <div align="center">
            <div class="form_con_ins">
                <div class="container">
                    <!--Formulaire-->
                    <form class="con_ins" method="POST" action="" enctype="multipart/form-data">
                        <p class="Titre_form">Edition</p>
                        <input class="input_form" type="text" name="newpseudo" id="newpseudo" maxlength="30" placeholder="Pseudo" placeholder="<?php echo $user['pseudo']; ?>" autocomplete="off" /></br>
                        <input class="input_form" type="password" name="newpass" id="newpass" placeholder="•••••••••••" autocomplete="off" /></br>
                        <input class="input_form" type="password" name="newpass2" id="newpass2" placeholder="•••••••••••" autocomplete="off" /></br>
                        <input class="input_form" type="email" id="newemail" name="newemail" placeholder="<?php echo $user['adresse_email']; ?>" autocomplete="off" /></br>
                        <input class="input_form" type="text" name="newbio" id="newbio" placeholder="Bio" style="resize:vertical;" autocomplete="off" /></br>
                        <input class="input_form" type="file" name="avatar" /></br>
                        <input class="input_form" type="submit" value="Mise à jour" />
                    </form>

                    <!--Ombres-->
                    <div class="drop_drop" id="drop_1"></div>
                    <div class="drop_drop" id="drop_2"></div>
                    <div class="drop_drop" id="drop_3"></div>
                    <div class="drop_drop" id="drop_4"></div>
                    <div class="drop_drop" id="drop_5"></div>
                </div>
            </div>
            <?php if(isset($erreur)) { echo $erreur; } ?>
        </div>

    </article>
</div>

<div class="right">
    <article style="margin-top:40%">
        <div>
            <span class="PTitle">Liens</span>
            <div id="links_list_list">
                <?php if ($req_liens->rowCount() > 0) { ?>
                
                    <?php while($l = $req_liens->fetch()) { ?>
                        <div class="links_list">
                            <a class="PActions links_text" href="<?= $l['url'] ?>"  rel="noreferrer noopener" title="<?= $l['url'] ?>">
                                <img src="https://www.google.com/s2/favicons?domain=<?= $l['nom'] ?>" height="16" />
                                <span><?= $l['nom'] ?></span>
                            </a>
                            <a><img class="links_buttons" id="one" src="assets/delete.png" onclick="delete_link(this)"/></a>
                        </div>
                    <?php } ?>
                <?php } ?>
            </div>
            <input style="max-width:100%" class="links_list" type="text" name="social_link" id="social_link" placeholder="https://www.twitter.com/Inflow" autocomplete="off"/></br>
            <button id="links_list_send" class="links_list" onclick="send_new_link()">Nouveau lien</button>
            <button id="links_list_error_message" class="links_list" style="display: none"></button>
        </div>
    </article>
</div>


<?php
// Le bas de l'interface est ajouté après le contenu
include 'tmpl_bottom.php';
?>

<link type="text/css" rel="stylesheet" href="style\editionprofil.css">
<script type="text/javascript" src="JS/editionprofil.js" defer></script>

<?php
}
} else {
    header("Location: Connexion.php");
}
?>