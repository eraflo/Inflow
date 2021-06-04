<?php
session_start();
$bdd = new PDO("mysql:host=127.0.0.1;dbname=inflow;charset=utf8", "root", "");


$search_auteur = $bdd->prepare('SELECT * FROM `membres` WHERE id = ?');
$recom = $bdd->query('SELECT * FROM `articles` ORDER BY nombre_like DESC LIMIT 6');

// compteur de visites
include 'stats_visites_site.php';
// Le haut de l'interface est ajouté avant le contenu
include 'tmpl_top.php';
?>
<?php
include 'MODULES/begin_left.php';
include 'MODULES/stats_visites_site.php';
include 'MODULES/categories.php';
include 'MODULES/end.php';
?>
<!--Début de là où on pourra mettre du texte-->
<div class="middle">
    <article>
    <h1>Recommandations :</h1>
                    <!--Affiche des recommendations d'articles à lire-->
                    <div class="articleRecommendationGallery articleGallery hcenter">
                        <?php while($a_r = $recom->fetch()) { 
                            ?>
                            <a href="Publication.php?id=<?= $a_r['id'] ?>" class="noUnderline cardArticleContainer">
                            <?php if(!empty($a_r['avatar_article'])) { ?>
                                <img class="cardArticleImage" src="membres/avatars_article/<?php echo $a_r['avatar_article']; ?>" href="Publication.php?id=<?= $a_r['id'] ?>" style="width:100%">
                            <?php } ?>
                                <div class="cardArticleContent">
                                    <p class="cardArticleTitle"><?= $a_r['titre'] ?></p>
                                    <p class="cardArticleMainText"><?= $a_r['descriptions'] ?></p>
                                    <?php 
                                    if(isset($a_r['id_auteur']) AND $a_r['id_auteur'] != NULL) {
                                        $search_auteur->execute(array($a_r['id_auteur'])); 
                                        $sa1 = $search_auteur->fetch();?>
                                        <p class="cardArticleSecondaryText"> <?= $sa1['pseudo'] ?></p>
                                        <?php } else { ?>
                                            <p class="cardArticleSecondaryText"> <?= $a_r['auteur'] ?></p>
                                        <?php } ?>
                                </div>
                            </a>
                        <?php } ?>
                    </div>
                    <br/>
    </article>
</div>
<div class="right"></div>
<?php 
// Le bas de l'interface est ajouté après le contenu
include 'tmpl_bottom.php'; 
?>