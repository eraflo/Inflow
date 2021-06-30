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
<form method="POST" action="" enctype="multipart/form-data">
                            <table>
                                <tr>
                                    <td align="right">
                                        <label for="name_event">Nom event :</label>
                                    </td>
                                    <td>
                                        <input type="text" name="name_event" id="name_event" placeholder="Name event"/>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="right">
                                        <label for="lien_event">Lien vers event :</label>
                                    </td>
                                    <td>
                                        <input type="text" name="lien_event" id="lien_event" placeholder="Lien event"/>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="right">
                                        <label for="horaire">Horaire :</label>
                                    </td>
                                    <td>
                                        <input type="text" name="horaire" id="horaire" placeholder="Horaire"/>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                    </td>
                                    <td align="left">
                                        <br />
                                        <input type="submit" value="Mise à jour" />
                                    </td>
                                </tr>
                            </table>
                        </form>
</div>
<div class="right">
</div>




<?php
include 'tmpl_bottom.php'; 
?>

<!--Application des fichiers css exclusifs-->
<link type="text/css" href="style\menu.css" rel="stylesheet">
<link type="text/css" href="style\articles.css" rel="stylesheet">
