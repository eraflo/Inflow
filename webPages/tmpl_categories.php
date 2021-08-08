<!--Page où apparaissent les catégories-->
<?php
session_start();
$bdd = new PDO("mysql:host=127.0.0.1;dbname=inflow;charset=utf8", "root", "");

if(isset($_GET['id']) AND !empty($_GET['id'])) {
    $get_id = htmlspecialchars($_GET['id']);
    $categorie = $bdd->prepare('SELECT * FROM categories WHERE id = ?');
    $categorie->execute(array($get_id));

    if($categorie->rowCount() == 1) {
        $categorie = $categorie->fetch();
        $id = $categorie['id'];
        $nom = $categorie['nom'];
        $description = $categorie['description'];

        $articles = $bdd->prepare('SELECT * FROM `articles` WHERE id_categories = ? ORDER BY articles.date_time_publication DESC');
        $articles->execute(array($id));

    } else {
        header('Location: Erreur.php');
    }
} else {
    header('Location: Erreur.php');
}

include 'tmpl_top.php'; 
?>
    <!--Début de là où on pourra mettre du texte-->
    <div class="middle">
        <article>

            <!--Affiche les articles-->
            <h1>
                <?= $nom ?>
            </h1>
            
            <div class="cardGallery hcenter">
                <?php while($a = $articles->fetch()) { ?>
                    <a href="Publication.php?id=<?= $a['id'] ?>" class="">
                        <div class="cardArticle" style='<?php if(!empty($a['avatar_article'])) { ?>
                        background: center url("membres/avatars_article/<?= $a['avatar_article'] ?>");
                        background-size: cover;backdrop-filter: grayscale(25%) blur(3px);<?php } ?>'>
                            <p class="title"><?= $a['titre'] ?></p>
                            <p class="desc"><?= $a['descriptions'] ?></p>
                            <p class="author"><?= $a['auteur'] ?></p>
                        </div>
                    </a>
                <?php } ?>
            </div>

        </article>
    </div>

    <div class="right"></div>
<?php 
// Le bas de l'interface est ajouté après le contenu
include 'tmpl_bottom.php'; 
?>

<!--Application des fichiers css exclusifs-->
<link type="text/css" href="style\articles.css" rel="stylesheet">
