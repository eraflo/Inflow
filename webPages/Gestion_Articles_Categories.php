<?php
session_start();
$bdd = new PDO("mysql:host=127.0.0.1;dbname=inflow;charset=utf8", "root", "");

include 'webp_convert.php';

if(!isset($_SESSION['redacteur']) OR $_SESSION['redacteur'] != 1 OR !isset($_SESSION) OR empty($_SESSION)) {
    header("Location: main.php");
}

// Obtenir les informations de l'article ou de la catégorie
if(isset($_GET['id']) AND !empty($_GET['id'])) {
    $get_id = htmlspecialchars($_GET['id']);

    // Obtenir les informations qui vont être utilisées dans la modification de l'article ou de la catégorie
    $articles = $bdd->query('SELECT * FROM articles');
    $auteurs = $bdd->query('SELECT * FROM `membres` WHERE redacteur = 1');
    $categories = $bdd->query('SELECT * FROM categories');

    // Post des modifications
    if(isset($_POST['article_titre'], $_POST['article_contenu'], $_POST['article_id_auteur'], $_POST['article_comment'])) {
        if (empty($_POST['article_id_auteur'])) {
            if(isset($_SESSION['redacteur']) AND $_SESSION['redacteur'] == 1 AND isset($_SESSION)) {
                $_POST['article_id_auteur'] = $_SESSION['id'];
            } else {
                $_POST['article_id_auteur'] = NULL;
            }
        }
        if(!empty($_POST['article_titre']) AND !empty($_POST['article_contenu']) AND !empty($_POST['article_id_auteur']) AND !empty($_POST['article_comment'])) {
            $article_titre = htmlspecialchars($_POST['article_titre']);
            $article_contenu = htmlspecialchars($_POST['article_contenu']);
            $article_id_auteur = htmlspecialchars($_POST['article_id_auteur']);
            $article_comment = htmlspecialchars($_POST['article_comment']);
            $article_id_categorie = htmlspecialchars($_POST['article_id_categorie']);
            //éviter erreurs d'encodage
            $article_contenu = utf8_encode($article_contenu);
            $article_contenu = str_replace('ï>>¿', '', $article_contenu);
            $article_contenu = utf8_decode($article_contenu);
            $article_contenu = nl2br($article_contenu);
            //obtenir le pseudo de l'auteur
            $getAuteur = $bdd->query('SELECT * FROM `membres` WHERE id = '.$article_id_auteur.' ');
            $article_auteur = $getAuteur->fetch();

            //création d'une nouvelle catégorie
            if($article_id_categorie == "Nouvelle") {
                $article_nom_categorie = htmlspecialchars($_POST['article_nom_categorie']);
                $article_desc_categorie = htmlspecialchars($_POST['article_desc_categorie']);
                $ins_cat = $bdd->prepare('INSERT INTO `categories` (nom, auteur, description, date_time_publication) VALUES (?, ?, ?, NOW())');
                $ins_cat->execute(array($article_nom_categorie, $article_auteur['pseudo'], $article_desc_categorie));

                $get_article_id_categorie = $bdd->query('SELECT id FROM `categories` WHERE nom = "'.$article_nom_categorie.'" LIMIT 1');
                $article_id_categorie = $get_article_id_categorie->fetch();
                $article_id_categorie = $article_id_categorie[0];
            }

            $ins = $bdd->prepare('UPDATE articles SET titre = ?, contenu = ?, auteur = ?, id_auteur = ?, descriptions = ?, id_categories = ? WHERE id = ?');
            $ins->execute(array($article_titre, $article_contenu, $article_auteur['pseudo'], $article_id_auteur, $article_comment, $article_id_categorie, $get_id));

            $tailleMax = 5242880;
            $extensionValides = array('jpg', 'png', 'jpeg', 'gif');
            if($_FILES['miniature']['size'] <= $tailleMax) {
                $extensionUpload = strtolower(substr(strrchr($_FILES['miniature']['name'], '.'), 1));
                if(in_array($extensionUpload, $extensionValides)) {
                    // Suppr les anciens avatars
                    array_map('unlink', glob('membres/avatars_article/'.$get_id.'.*'));

                    $chemin = "membres/avatars_article/".$get_id.".".$extensionUpload;
                    move_uploaded_file($_FILES['miniature']['tmp_name'], $chemin);
                    generate_webp_image($chemin);
                    $ins2 = $bdd->prepare("UPDATE articles SET avatar_article = :avatar WHERE id = :id");
                    $ins2->execute(array(
                        'avatar' => $get_id.".".$extensionUpload,
                        'id' => $get_id
                        ));
                }
            }
            $message = "Votre article a bien été modifié<br/><a class=\"underline\" href=\"Publication.php?id=".$get_id."\">Retour à l\'article</a>";


        } else {
            $message = 'Veuillez remplir tous les champs';
        }
    } elseif(isset($_POST['categorie_nom'], $_POST['categorie_auteur'], $_POST['categorie_description'])) {
        $categorie_nom = htmlspecialchars($_POST['categorie_nom']);
        $categorie_auteur = htmlspecialchars($_POST['categorie_auteur']);
        $categorie_description = htmlspecialchars($_POST['categorie_description']);
        //éviter erreurs d'encodage
        $categorie_description = utf8_encode($categorie_description);
        $categorie_description = str_replace('ï>>¿', '', $categorie_description);
        $categorie_description = utf8_decode($categorie_description);
        $categorie_description = nl2br($categorie_description);

        $ins = $bdd->prepare('UPDATE categories SET nom = ?, auteur = ?, description = ? WHERE id = ?');
        $ins->execute(array($categorie_nom, $categorie_auteur, $categorie_description, $get_id));
        
        $tailleMax = 5242880;
        $extensionValides = array('jpg', 'png', 'jpeg', 'gif');
        if($_FILES['miniature_categorie']['size'] <= $tailleMax) {
            $extensionUpload = strtolower(substr(strrchr($_FILES['miniature_categorie']['name'], '.'), 1));
            if(in_array($extensionUpload, $extensionValides)) {
                // Suppr les anciens avatars
                array_map('unlink', glob('membres/avatars_categorie/'.$get_id.'.*'));

                $chemin = "membres/avatars_categorie/".$get_id.".".$extensionUpload;
                move_uploaded_file($_FILES['miniature_categorie']['tmp_name'], $chemin);
                generate_webp_image($chemin);
                $ins2 = $bdd->prepare("UPDATE categories SET avatar_categorie = :avatar WHERE id = :id");
                $ins2->execute(array(
                    'avatar' => $get_id.".".$extensionUpload,
                    'id' => $get_id
                    ));
            }
        }
        $message = "Votre catégorie a bien été modifié<br/><a class=\"underline\" href=\"tmpl_categories.php?id=".$get_id."\">Retour à la categorie</a>";

    }

    if(isset($_GET['type']) && !empty($_GET['type'])){
        $get_type = htmlspecialchars($_GET['type']);
        if($get_type == "article"){
            $article = $bdd->prepare('SELECT * FROM articles WHERE id = ?');
            $article->execute(array($get_id));
            if($article->rowCount() == 1) {
                $article = $article->fetch();
                $id = $article['id'];
                $titre = $article['titre'];
                $contenu = $article['contenu'];

                $likes = $bdd->prepare('SELECT id FROM likes WHERE id_article = ?');
                $likes->execute(array($id));
                $likes = $likes->rowCount();

                $dislikes = $bdd->prepare('SELECT id FROM dislikes WHERE id_article = ?');
                $dislikes->execute(array($id));
                $dislikes = $dislikes->rowCount();

                $req_article_categorie = $bdd->prepare('SELECT nom FROM `categories` WHERE id = ?');
                $req_article_categorie->execute(array($article['id_categories']));
                $article_categorie = $req_article_categorie->fetch();
                if (!is_null($article_categorie) && $article_categorie != false){
                    $article_categorie = $article_categorie[0];
                } else {
                    $article_categorie = "";
                }
                include 'Modification_Articles.php';
            } else {
                die('Cette article n\'existe pas !!!');
            }
        } elseif($get_type == "categorie") {
            $categorie = $bdd->prepare('SELECT * FROM `categories` WHERE id = ?');
            $categorie->execute(array($get_id));
            if($categorie->rowCount() == 1) {
                $categorie = $categorie->fetch();
                $id = $categorie['id'];

                include 'Modification_Categories.php';
            } else {
                die('Cette catégorie n\'existe pas !!!');
            }
        } else {
            die('Le type de contenu n\'existe pas !!!');
        }
    } else {
        die('Le type de contenu doit être donné !!!');
    }

    
} else {
    include 'Selection_Articles_Categories.php';
}

// Le bas de l'interface est ajouté après le contenu
include 'tmpl_bottom.php';
?>
