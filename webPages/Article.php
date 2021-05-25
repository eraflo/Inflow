<!--Page recensant tout les articles -> quand clique sur titre article, rediriger sur article dans Publication.html-->
<?php
include 'tmpl_top.php'; 
$bdd = new PDO("mysql:host=127.0.0.1;dbname=articles;charset=utf8", "root", "");
$bdd2 = new PDO("mysql:host=127.0.0.1;dbname=espace_membre;charset=utf8", "root", "");

$articles = $bdd->query('SELECT * FROM articles ORDER BY date_time_publication DESC LIMIT 0,5');

$articlesParPage = 5;
$articlesTotalReq = $bdd->query('SELECT id FROM articles');
$articlesTotal = $articlesTotalReq->rowCount();

$pagesTotales = ceil($articlesTotal/$articlesParPage);

if(isset($_GET['page']) AND !empty($_GET['page']) AND $_GET['page'] > 0 AND $_GET['page'] <= $pagesTotales) {
    $_GET['page'] = intval($_GET['page']);
    $pageCourante = $_GET['page'];

} else {
    $pageCourante = 1;
}

$depart = ($pageCourante-1)*$articlesParPage;
$articles = $bdd->query('SELECT * FROM articles ORDER BY date_time_publication DESC LIMIT '.$depart.','.$articlesParPage.''); 
?>
            <div class="left">
                <div class="navElement"><a href="Rap.php">Rap</a></div>
                <div class="navElement"><a href="MusiqueUrbaine.php">Musique Urbaine</a></div>
                <div class="navElement"><a href="ChroniquesJason.php">Les Chroniques de Jason</a></div>
            </div>

            <!--Début de là où on pourra mettre du texte-->
            <div class="middle">
                <article>

                    <!--Affiche les titres de chaque article, cliquer dessus amène sur l'article-->
                    <ul>
                        <?php while($a = $articles->fetch()) { ?>
                        <li>
                            <a href="Publication.php?id=<?= $a['id'] ?>">
                                <?= $a['titre'] ?>
                            </a>
                        </li>
                        <?php } ?>
                        <?php
                        for($i=1;$i<=$pagesTotales;$i++) {
                            if($i == $pageCourante) {
                                echo '<a class="selected">'.$i.' </a>';
                            } else {
                                echo '<a href="Article.php?page='.$i.'">'.$i.'</a>';
                            }
                        }
                        ?>
                    </ul>

                </article>
            </div>

            <div class="right"></div>
<?php 
// Le bas de l'interface est ajouté après le contenu
include 'tmpl_bottom.php'; 
?>