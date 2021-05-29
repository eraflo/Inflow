<?php
session_start();
$bdd = new PDO("mysql:host=127.0.0.1;dbname=espace_membre;charset=utf8", "root", "");
$membres2 = $bdd->query('SELECT * FROM membres');
$m = $membres2->fetch();
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

            <h3>Playlist 1</h3>



            <p>Début</p>

        </article>
    </div>

    <div class="right"></div>
<?php 
// Le bas de l'interface est ajouté après le contenu
include 'tmpl_bottom.php'; 
?>