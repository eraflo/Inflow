<?php
session_start();
$bdd = new PDO("mysql:host=127.0.0.1;dbname=inflow;charset=utf8", "root", "");

//appel parser.php
require_once "JBBCode/Parser.php";

if(!isset($_SESSION['redacteur']) OR $_SESSION['redacteur'] != 1 OR !isset($_SESSION) OR empty($_SESSION)) {
    header("Location: main.php");
}

// Obtenir les informations de l'article
if(isset($_GET['id']) AND !empty($_GET['id'])) {
    $get_id = htmlspecialchars($_GET['id']);
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

            $lastid = $bdd->LastInsertId();

            $tailleMax = 5242880;
            $extensionValides = array('jpg', 'png', 'jpeg', 'gif');
            if($_FILES['miniature']['size'] <= $tailleMax) {
                $extensionUpload = strtolower(substr(strrchr($_FILES['miniature']['name'], '.'), 1));
                if(in_array($extensionUpload, $extensionValides)) {
                    $chemin = "membres/avatars_article/".$lastid.".".$extensionUpload;
                    move_uploaded_file($_FILES['miniature']['tmp_name'], $chemin);
                    $ins2 = $bdd->prepare("UPDATE articles SET avatar_article = :avatar WHERE id = :id");
                    $ins2->execute(array(
                        'avatar' => $lastid.".".$extensionUpload,
                        'id' => $lastid
                        ));
                }
            }
            $message = 'Votre article a bien été modifié';

        } else {
            $message = 'Veuillez remplir tous les champs';
        }
    }

    $article = $bdd->prepare('SELECT * FROM articles WHERE id = ?');
    $article->execute(array($get_id));

    //Changer code BBCode en html
    $parser = new JBBCode\Parser();
    $parser->addCodeDefinitionSet(new JBBCode\DefaultCodeDefinitionSet());
    $parser->addBBCode("quote", '<blockquote>{param}</blockquote>');
    $parser->addBBCode("&nbsp;", '<br/>{param}');

    $articles = $bdd->query('SELECT * FROM articles');
    $auteurs = $bdd->query('SELECT * FROM `membres` WHERE redacteur = 1');
    $categories = $bdd->query('SELECT * FROM categories');

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

        $vues = 0; // pas encore implémenté


        $req_article_categorie = $bdd->prepare('SELECT nom FROM `categories` WHERE id = ?');
        $req_article_categorie->execute(array($article['id_categories']));
        $article_categorie = $req_article_categorie->fetch();
        if (!is_null($article_categorie) && $article_categorie != false){
            $article_categorie = $article_categorie[0];
        } else {
            $article_categorie = "";
        }

    } else {
        die('Cette article n\'existe pas !!!');
    }
    include 'Modification_Articles_Categories.php';
} else {
    include 'Selection_Articles_Categories.php';
}

?>
