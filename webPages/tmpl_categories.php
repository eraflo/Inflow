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
            <?php if(isset($_SESSION['redacteur']) AND $_SESSION['redacteur'] == 1 AND isset($_SESSION)) { ?>
                <!--Edition--><a href="Gestion_Articles_Categories.php?type=categorie&id=<?= $get_id ?>" class="" title="Modifier la catégorie"><img class="to_invert editButton" src="assets/edit.png" title="Modifier la catégorie" /></a>
                <!--Statistiques-->
            <?php } ?>
            
            <div class="card_article">
                <?php while($a = $articles->fetch()) { ?>
                    <div class="card">
                        <a href="Publication.php?id=<?= $a['id'] ?>">
                            <div class="text_card">
                                <div class="titre"><?= $a['titre'] ?></div>
                                <div class="auteur"><?= $a['auteur'] ?></div>
                                <div class="description"><?= $a['descriptions'] ?></div>
                                <div class="date"><?= date('m/d', strtotime($a['date_time_publication'])) ?></div>  
                            </div>
                            <div class="miniature">
                                <?php if(!empty($a['avatar_article'])) { ?>
                                    <picture>
                                        <source srcset="membres/avatars_article/<?=$a['avatar_article'].'.webp'?>" type="image/webp">
                                        <img src="membres/avatars_article/<?=$a['avatar_article']?>" type="image/png">
                                    </picture>
                                <?php } ?>
                            </div>
                        </a>
                    </div>
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
