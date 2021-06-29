<?php
session_start();
$bdd = new PDO("mysql:host=127.0.0.1;dbname=inflow;charset=utf8", "root", "");

$data = $bdd->prepare("SELECT * FROM historique WHERE id_pseudo = ? ORDER BY date_visite DESC");
$data->execute(array($_SESSION["id"]));

include 'tmpl_top.php';



?>


<?php
include 'MODULES/begin_left.php';
include 'MODULES/categories.php';
include 'MODULES/stats_visites_site.php';
include 'MODULES/end.php';
?>
<!--Début de là où on pourra mettre du texte-->
<div class="middle">
    <?php while($d = $data->fetch()) { 
        $search_art = $bdd->prepare("SELECT * FROM articles WHERE id = ?");
        $search_art->execute(array($d["id"]));
        $s = $search_art->fetch();?>
        <p><?php echo $s["titre"];?> <?php if(isset($s["auteur"]) AND !empty($s["auteur"])) { ?> : <?php echo $s["auteur"]; } ?></p>
    <?php } ?>

</div>
<div class="right">
</div>




<?php
include 'tmpl_bottom.php'; 
?>

<!--Application des fichiers css exclusifs-->
<link type="text/css" href="style\menu.css" rel="stylesheet">
<link type="text/css" href="style\articles.css" rel="stylesheet">
