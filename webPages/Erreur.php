<?php
session_start();
$bdd = new PDO("mysql:host=127.0.0.1;dbname=inflow;charset=utf8", "root", "");

include 'stats_visites_site.php';

// Le haut de l'interface est ajouté avant le contenu
include 'tmpl_top.php'; 
?>
<!--Début de là où on pourra mettre du texte-->
<div class="middle">
    <article>
        <h1>Erreur 404 : page not found</h1>
    </article>
</div>
<div class="right"></div>
<?php 
// Le bas de l'interface est ajouté après le contenu
include 'tmpl_bottom.php'; 
?>