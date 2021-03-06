<!--Charger base de donnée + Lorsque formulaire remplie pour poster un article, rentre les infos dans la base de donnée-->
<?php
session_start();
$bdd = new PDO("mysql:host=127.0.0.1;dbname=inflow;charset=utf8", "root", "");

include 'stats_visites_site.php';
include 'webp_convert.php';

if(!isset($_SESSION['redacteur']) OR $_SESSION['redacteur'] != 1 OR !isset($_SESSION) OR empty($_SESSION)) {
    header("Location: main.php");
}

$auteurs = $bdd->query('SELECT * FROM `membres` WHERE redacteur = 1');
$categories = $bdd->query('SELECT * FROM categories');


if(isset($_POST['article_titre'], $_POST['article_contenu'], $_POST['article_id_auteur'], $_POST['article_comment'])) {
    if (empty($_POST['article_id_auteur'])) {
        if(isset($_SESSION['redacteur']) AND $_SESSION['redacteur'] == 1 AND isset($_SESSION)) {
            $_POST['article_id_auteur'] = $_SESSION['id'];
        } else {
            $_POST['article_id_auteur'] = NULL;
        }
    }
    if(!empty($_POST['article_titre']) AND !empty($_POST['article_contenu']) AND !empty($_POST['article_id_auteur']) AND !empty($_POST['article_comment'])) {
        //informations générales de l'article
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

            $tailleMax = 5242880;
            $extensionValides = array('jpg', 'png', 'jpeg', 'gif');
            if($_FILES['miniature_categorie']['size'] <= $tailleMax) {
                $extensionUpload = strtolower(substr(strrchr($_FILES['miniature_categorie']['name'], '.'), 1));
                if(in_array($extensionUpload, $extensionValides)) {
                    $chemin = "membres/avatars_categorie/".$article_id_categorie.".".$extensionUpload;
                    move_uploaded_file($_FILES['miniature_categorie']['tmp_name'], $chemin);
                    generate_webp_image($chemin);
                    $ins2 = $bdd->prepare("UPDATE categories SET avatar_categorie = :avatar WHERE id = :id");
                    $ins2->execute(array(
                        'avatar' => $article_id_categorie.".".$extensionUpload,
                        'id' => $article_id_categorie
                        ));
                }
            }
        }

        $ins = $bdd->prepare('INSERT INTO articles (titre, contenu, auteur, id_auteur, descriptions, date_time_publication, id_categories)
            VALUES (?, ?, ?, ?, ?, NOW(), ?)');
        $ins->execute(array($article_titre, $article_contenu, $article_auteur['pseudo'], $article_id_auteur, $article_comment, $article_id_categorie));

        $lastid = $bdd->LastInsertId();

        $s_id = $bdd->prepare("SELECT * FROM articles WHERE titre = ? AND auteur = ?");
        $s_id->execute(array($article_titre, $article_auteur['pseudo']));
        $s_ID = $s_id->fetch();
        
        $tailleMax = 5242880;
        $extensionValides = array('jpg', 'png', 'jpeg', 'gif');
        if($_FILES['miniature']['size'] <= $tailleMax) {
            $extensionUpload = strtolower(substr(strrchr($_FILES['miniature']['name'], '.'), 1));
            if(in_array($extensionUpload, $extensionValides)) {
                $chemin = "membres/avatars_article/".$lastid.".".$extensionUpload;
                move_uploaded_file($_FILES['miniature']['tmp_name'], $chemin);
                generate_webp_image($chemin);
                $ins2 = $bdd->prepare("UPDATE articles SET avatar_article = :avatar WHERE id = :id");
                $ins2->execute(array(
                    'avatar' => $lastid.".".$extensionUpload,
                    'id' => $lastid
                    ));
            }
        }
        $ins_new = $bdd->prepare('INSERT INTO nouveauté (date_time_publication, type_new, nom, lien, avatar_event) VALUES(NOW(), 0, ?, ?, ?)');
        $ins_new->execute(array($article_titre, $s_ID['id'], $s_ID['avatar_article']));
        
        $message = 'Votre article a bien été posté';

    } else {
        $message = 'Veuillez remplir tous les champs';
    }
}
include 'tmpl_top.php';
?>
<?php
include 'MODULES/begin_left.php';
include 'MODULES/categories.php';
include 'MODULES/end.php';
?>
<head>
<!--Charger ressources pour éditeur de texte-->
    <!--Trumbowyg resources-->
    <link rel="stylesheet" href="JS/trumbowyg/ui/trumbowyg.min.css" media="none" onload="if(media!='all')media='all'">
    <noscript><link href="JS/trumbowyg/ui/trumbowyg.min.css" rel="stylesheet"></noscript>
    <script type="text/javascript" src="JS/trumbowyg/trumbowyg.min.js" defer></script>
    <script type="text/javascript" src="JS/trumbowyg/langs/fr.js" defer></script>
    <!--Plugins for Trumbowyg-->
    <script src="JS/trumbowyg/plugins/pasteembed/trumbowyg.pasteembed.min.js" defer></script>
    <script src="JS/trumbowyg/plugins/pasteimage/trumbowyg.pasteimage.min.js" defer></script>
    <script src="JS/trumbowyg/plugins/history/trumbowyg.history.min.js" defer></script>
    <script src="JS/trumbowyg/plugins/resizimg/trumbowyg.resizimg.min.js" defer></script>
    <script src="JS/trumbowyg/plugins/resizimg/jquery-resizable.min.js" defer></script>
    <script src="JS/trumbowyg/plugins/colors/trumbowyg.colors.min.js" defer></script>
    <link rel="stylesheet" href="JS/trumbowyg/plugins/colors/ui/trumbowyg.colors.min.css">
    <!--Init Trumbowyg-->
    <script type="text/javascript" src="JS/trumbowyg/trumbowyg.js" defer></script>

    <script src="JS/categories.js" defer></script>
</head>
<!--Début de là où on pourra mettre du texte-->
<div class="middle">
    <article class="ProfilTxt">
        <!--Formulaire pour postez des articles-->
        <form method="POST" enctype="multipart/form-data" class="con_ins">
            <input class="input_form" type="text" name="article_titre" placeholder="Titre" />
            <select class="input_form" type="text" name="article_id_auteur" placeholder="Auteur">
                <option value=""><i>Auteur</i></option>
                <?php while($a = $auteurs->fetch()) { ?>
                    <option value="<?= $a['id'] ?>"><?= $a['pseudo'] ?></option>
                <?php } ?>
            </select><br/>
            <select class="input_form" id="categorie_selection" type="text" name="article_id_categorie">
                <option value="" style="font-style:italic;">Aucune catégorie</option>
                <option value="Nouvelle" style="font-weight:bold;">Nouvelle catégorie</option>
                <?php while($c = $categories->fetch()) { ?>
                    <option value="<?= $c['id'] ?>"><?= $c['nom'] ?></option>
                <?php } ?>
            </select><br/>
            <input class="input_form" id="categorie_name" type="text" name="article_nom_categorie" placeholder="Nom de la catégorie" />
            <input class="input_form" id="categorie_desc" type="text" name="article_desc_categorie" placeholder="Description de la catégorie" /><br/>
            <div id="categorie_img_div">
                <label class="Titre_form" for="miniature_categorie">Miniature de la catégorie : </label>
                <input class="input_form" id="categorie_img" type="file" name="miniature_categorie"/>
            </div><br/>
            <textarea class="input_form" type="text" name="article_comment" placeholder="Description" style="resize:vertical;width:100%"></textarea><br/>
            <div style="text-align:initial;">
                <textarea class="input_form" id="editor" name="article_contenu" placeholder="Contenu de l'article"></textarea>
            </div><br/>
            <label class="Titre_form" for="miniature">Miniature de l'article : </label><input class="input_form" type="file" name="miniature"/><br/>
            <input class="input_form" type="submit" value="Envoyer l'article" /><br />
        </form>
        <br />
        <!--Affiche message en lien avec le transfert des données du formulaire.
            Ex : 1 des champs n'est pas remplie -> Affiche "Erreur"; Si tout est bien remplie, affiche "Votre article a été posté"-->
        <?php if(isset($message)) { echo $message; } ?>
        <br />
    </article>
</div>

<div class="right"></div>
<?php 
// Le bas de l'interface est ajouté après le contenu
include 'tmpl_bottom.php'; 
?>