<?php
session_start();
$bdd = new PDO("mysql:host=127.0.0.1;dbname=inflow;charset=utf8", "root", "");

if(!isset($_SESSION['admin']) OR $_SESSION['admin'] != 1 OR !isset($_SESSION) OR empty($_SESSION)) {
    header("Location: main.php");
}

if(isset($_POST['name_event']) AND !empty($_POST['name_event']) AND isset($_POST['lien_event']) AND !empty($_POST['lien_event']) AND isset($_POST['horaire']) AND !empty($_POST['horaire'])) {
    $name_event = htmlspecialchars($_POST['name_event']);
    $lien_event = htmlspecialchars($_POST['lien_event']);
    $horaire = htmlspecialchars($_POST['horaire']);
    $insertevent = $bdd->prepare("INSERT INTO nouveauté (date_time_publication, type_new, nom, lien, horaire) VALUES(NOW(), 2, ?, ?, ?)");
    $insertevent->execute(array($name_event, $lien_event, $horaire));
    header("Location: main.php");
}

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
<div class="form_con_ins">
    <div class="container">
        <!--Formulaire-->
        <form class="con_ins" method="POST" action="" enctype="multipart/form-data">
            <p class="Titre_form">Events</p>
            <input class="input_form" type="text" name="name_event" id="name_event" placeholder="Nom event"/></br>
            <input class="input_form" type="text" name="lien_event" id="lien_event" placeholder="Lien event"/></br>
            <input class="input_form" type="text" name="horaire" id="horaire" placeholder="Horaire"/></br>
            <input class="input_form" type="submit" value="Mise à jour" />
        </form>

        <!--Ombres-->
        <div class="drop_drop" id="drop_1"></div>
        <div class="drop_drop" id="drop_2"></div>
        <div class="drop_drop" id="drop_3"></div>
        <div class="drop_drop" id="drop_4"></div>
        <div class="drop_drop" id="drop_5"></div>
    </div>
</div>
</div>
<div class="right">
</div>




<?php
include 'tmpl_bottom.php'; 
?>

<!--Application des fichiers css exclusifs-->
<link type="text/css" href="style\menu.css" rel="stylesheet">
<link type="text/css" href="style\articles.css" rel="stylesheet">
