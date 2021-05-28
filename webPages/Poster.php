<!--Charger base de donnée + Lorsque formulaire remplie pour poster un article, rentre les infos dans la base de donnée-->
<?php
include 'tmpl_top.php'; 
$bdd = new PDO("mysql:host=127.0.0.1;dbname=articles;charset=utf8", "root", "");
$bdd2 = new PDO("mysql:host=127.0.0.1;dbname=espace_membre;charset=utf8", "root", "");


if(isset($_POST['article_titre'], $_POST['article_contenu'])) {
    if(!empty($_POST['article_titre']) AND !empty($_POST['article_contenu'])) {

        $article_titre = htmlspecialchars($_POST['article_titre']);
        $article_contenu = htmlspecialchars($_POST['article_contenu']);
        //éviter erreurs d'encodage
        $article_contenu = utf8_encode($article_contenu);
        $article_contenu = str_replace('ï>>¿', '', $article_contenu);
        $article_contenu = utf8_decode($article_contenu);

        $ins = $bdd->prepare('INSERT INTO articles (titre, contenu, date_time_publication)
            VALUES (?, ?, NOW())');
        $ins->execute(array($article_titre, $article_contenu));

        $message = 'Votre article a bien été posté';

    } else {
        $message = 'Veuillez remplir tous les champs';
    }
}

?>

    <div class="left">
        <div class="navElement"><a href="Rap.php">Rap</a></div>
        <div class="navElement"><a href="MusiqueUrbaine.php">Musique Urbaine</a></div>
        <div class="navElement"><a href="ChroniquesJason.php">Les Chroniques de Jason</a></div>
    </div>

    <!--Début de là où on pourra mettre du texte-->
    <div class="middle">
        <article>
            <!--Formulaire pour postez des articles-->
            <form method="POST" enctype="multipart/form-data">
                <input type="text" name="article_titre" placeholder="Titre" /> <br/>
                <textarea id="editor" name="article_contenu" placeholder="Contenu de l'article"></textarea><br/>
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