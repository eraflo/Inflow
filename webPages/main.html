<?php
$bdd = new PDO("mysql:host=127.0.0.1;dbname=articles;charset=utf8", "root", "");

if(isset($_POST['article_titre'], $_POST['article_contenu'])) {
    if(!empty($_POST['article_titre']) AND !empty($_POST['article_contenu'])) {


        $article_titre = htmlspecialchars($_POST['article_titre']);
        $article_contenu = htmlspecialchars($_POST['article_contenu']);

        $ins = $bdd->prepare('INSERT INTO articles (titre, contenu, date_time_publication)
            VALUES (?, ?, NOW())');
        $ins->execute(array($article_titre, $article_contenu));

        $message = 'Votre article a bien été posté';

    } else {
        $message = 'Veuillez remplir tous les champs';
    }
}

?>

<!DOCTYPE html>
<html>

<head>
    <!--Pour mettre des commentaires dans le code, respecter ma syntaxe-->
    <meta charset="UTF-8">
    <!-- Paramètre d'affichage mobile -->
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <!-- Gestion du navigateur IE -->
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Inflow</title>
    <!--Appliquer le style css et importer l'icone-->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,400;0,700;1,400;1,700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="style.css" />
    <link rel="icon" href="assets/Inflow_logo_64px.png" />
    <script src="jquery-3.6.0.min.js"></script>
    <script type="text/javascript" src="script.js"></script>
</head>



<body>

    <!--Titre de la page web où on se trouve-->
    <img class="bannière" src="assets/banniere_twi.png" />

    <!--Header, c'est-à-dire, le menu pour changer de page-->
    <header class="header">
        <nav class="menu">
            <div class="menuElement"><a href="main.php" class="selected">Menu</a></div>
            <div class="menuElement"><a href="Article.php">Article</a></div>
            <div class="menuElement"><a href="Playlist.html">Playlist</a></div>
            <div class="dropdown menuElement"><a href="#">Espace Membre</a>
                <div class="dropdown-content">
                    <div class="menuElement"><a href="Inscription.html">Inscription</a></div>
                    <div class="menuElement"><a href="Connexion.html">Connexion</a></div>
                </div>
            </div>
            <div class="menuElement"><a href="Infos.html" id="Infos">Infos</a></div>
            <!-- search bar right align -->
            <div class="search">
                <form action="#">
                    <input type="text" placeholder="Recherche" name="search">
                    <button>
                    </button>
                </form>
            </div>
        </nav>
    </header>

    <!--Début de là où on pourra mettre du texte-->
    <article>
        <form method="POST">
            <input type="text" name="article_titre" placeholder="Titre" /> </br>
            <textarea name="article_contenu" placeholder="Contenu de l'article"></textarea></br>
            <input type="submit" value="Envoyer l'article"/></>
        </form>
        <br/>
        <?php if(isset($message)) { echo $message; } ?>
        <br/>
    <article>


    <!--Tout en bas de la page web, contient des infos-->
    <footer>
        <p> Articles et actus sur le rap - <i>Axelito à l'origine</i> - <a href="https://discord.com/channels/826440352810139678/826491405856800788" style="color: white">Rejoignez le Discord !</a></p>
        <button id="darkTrigger" class="btn">Thème sombre</button>

    </footer>


</body>

</html>