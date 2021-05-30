<!--Page où apparaissent les publications; Reste à améliorer le style et la mise en page mais opérationnel-->
<!--Connecte à base de données + gère affiche des articles-->
<?php
session_start();
$bdd = new PDO("mysql:host=127.0.0.1;dbname=articles;charset=utf8", "root", "");
$bdd2 = new PDO("mysql:host=127.0.0.1;dbname=espace_membre;charset=utf8", "root", "");

if(isset($_GET['id']) AND !empty($_GET['id'])) {
    $get_id = htmlspecialchars($_GET['id']);
    $categorie = $bdd->prepare('SELECT * FROM categories WHERE id = ?');
    $categorie->execute(array($get_id));

    if($categorie->rowCount() == 1) {
        $categorie = $categorie->fetch();
        $id = $categorie['id'];
        $nom = $categorie['nom'];
        $description = $categorie['description'];

        $articles = $bdd->prepare('SELECT * FROM `articles` JOIN `categories` ON categories.id = id_categories WHERE id_categories = ? ORDER BY articles.date_time_publication DESC');
        $articles->execute(array($get_id));

    } else {
        die('Cette catégorie n\'existe pas !!!');
    }
} else {
    die('Erreur');
}

include 'tmpl_top.php'; 
?>

            <div class="left">
                <div class="navElement"><a href="Rap.php">Rap</a></div>
                <div class="navElement"><a href="MusiqueUrbaine.php">Musique Urbaine</a></div>
                <div class="navElement"><a href="ChroniquesJason.php">Les Chroniques de Jason</a></div>
            </div>

            <!--Début de là où on pourra mettre du texte-->
            <div class="middle">
                <article>

                    <!--Affiche les articles-->
                    <h1>
                        <?= $nom ?>
                    </h1>
                    
                    <div class="articleCategoryGallery articleGallery hcenter">
                        <?php while($a = $articles->fetch()) { ?>
                            <a href="Publication.php?id=<?= $a['id'] ?>" class="noUnderline cardArticleElement">
                            <?php if(!empty($a['avatar_article'])) { ?>
                                <img class="cardArticleImage" src="membres/avatars_article/<?php echo $a['avatar_article']; ?>" href="Publication.php?id=<?= $a['id'] ?>" style="width:100%">
                            <?php } ?>
                                <div class="cardArticleContent">
                                    <p class="cardArticleTitle"><?= $a['titre'] ?></p>
                                    <p class="cardArticleMainText"><?= $a['descriptions'] ?></p>
                                    <p class="cardArticleSecondaryText"><?= $a['auteur'] ?></p>
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