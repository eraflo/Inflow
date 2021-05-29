<?php
session_start();
// Le haut de l'interface est ajouté avant le contenu
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
        <a href="Profil.php?id=6">Jason</a>
        <a href="Profil.php?id=2">Anyr</a>
        <a href="Profil.php?id=4">Axel</a>
    </article>
</div>
<div class="right"></div>
<?php 
// Le bas de l'interface est ajouté après le contenu
include 'tmpl_bottom.php'; 
?>