<!--Charger base de donnée + Lorsque formulaire remplie pour poster un article, rentre les infos dans la base de donnée-->
<?php
session_start();
$bdd = new PDO("mysql:host=127.0.0.1;dbname=articles;charset=utf8", "root", "");
$bdd2 = new PDO("mysql:host=127.0.0.1;dbname=espace_membre;charset=utf8", "root", "");

$auteurs = $bdd2->query('SELECT * FROM `membres` WHERE redacteur = 1');
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
        $article_titre = htmlspecialchars($_POST['article_titre']);
        $article_contenu = htmlspecialchars($_POST['article_contenu']);
        $article_id_auteur = htmlspecialchars($_POST['article_id_auteur']);
        $article_comment = htmlspecialchars($_POST['article_comment']);
        $article_id_categorie = htmlspecialchars($_POST['article_id_categorie']);
        //éviter erreurs d'encodage
        $article_contenu = utf8_encode($article_contenu);
        $article_contenu = str_replace('ï>>¿', '', $article_contenu);
        $article_contenu = utf8_decode($article_contenu);
        //obtenir le pseudo de l'auteur
        $getAuteur = $bdd2->query('SELECT * FROM `membres` WHERE id = '.$article_id_auteur.' ');
        $article_auteur = $getAuteur->fetch();

        $ins = $bdd->prepare('INSERT INTO articles (titre, contenu, auteur, id_auteur, descriptions, date_time_publication, id_categorie)
            VALUES (?, ?, ?, ?, ?, NOW(), ?)');
        $ins->execute(array($article_titre, $article_contenu, $article_auteur['pseudo'], $article_id_auteur, $article_comment, $article_id_categorie));

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
        $message = 'Votre article a bien été posté';

    } else {
        $message = 'Veuillez remplir tous les champs';
    }
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
            <!--Formulaire pour postez des articles-->
            <form method="POST" enctype="multipart/form-data">
                <input type="text" name="article_titre" placeholder="Titre" /> <br/>
                <select type="text" name="article_id_auteur" placeholder="Auteur">
                    <option value=""><i>Auteur</i></option>
                    <?php while($a = $auteurs->fetch()) { ?>
                        <option value="<?= $a['id'] ?>"><?= $a['pseudo'] ?></option>
                    <?php } ?>
                </select><br/>
                <select type="text" name="article_id_categorie">
                    <option value=""><i>Aucune catégorie</i></option>
                    <?php while($c = $categories->fetch()) { ?>
                        <option value="<?= $c['id'] ?>"><?= $c['nom'] ?></option>
                    <?php } ?>
                </select><br/>
                <input type="text" name="article_comment" placeholder="Description" /> <br/>
                <textarea id="editor" name="article_contenu" placeholder="Contenu de l'article"></textarea><br/>
                <input type="file" name="miniature"/><br/>
                <input type="submit" value="Envoyer l'article" /><br />
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