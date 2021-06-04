
<?php // Page de paramètres modifiables par l'utilisateur
session_start();
$bdd = new PDO("mysql:host=127.0.0.1;dbname=inflow;charset=utf8", "root", "");

$CHANGE_JS = false;

if(isset($_SESSION['id']) AND !empty($_SESSION['id'])) {
    $requser = $bdd->prepare('SELECT * FROM membres WHERE id = ?');
    $requser->execute(array($_SESSION['id']));
    $userinfos = $requser->fetch();

    // Rechercher les informations de la base de données
    $reqsettings = $bdd->prepare('SELECT * FROM membres WHERE id = ?');
    $reqsettings->execute(array($_SESSION['id']));
    $settings = $reqsettings->fetch();

    $reqfont = $bdd->prepare('SELECT nom_police FROM police_ecriture WHERE id_police = ?');
    $reqfont->execute(array($settings['font']));
    $font = $reqfont->fetch();

    $reqtheme = $bdd->prepare('SELECT nom_theme FROM themes_couleurs WHERE id_theme = ?');
    $reqtheme->execute(array($settings['user_color_mode']));
    $theme = $reqtheme->fetch();

    
    if(isset($_POST['police'])) {
        $CHANGE_JS = true;
        // Insérer dans la base de données
        $reqfontname = $bdd->prepare('SELECT id_police FROM police_ecriture WHERE nom_police = ?');
        $reqfontname->execute(array($_POST['polices']));
        $fontname = $reqfontname->fetch();
        $insertPolice = $bdd->prepare("UPDATE membres SET font = ? WHERE id = ?");
        $insertPolice->execute(array($fontname[0], $_SESSION['id']));

        header("Location: Parametres.php");
    }
}

include 'tmpl_top.php';

if (isset($font) && !empty($font)){
    echo '<script>font = "'.$font[0].'";</script>';
} else {
    echo '<script>font = 0;</script>';
}
if (isset($theme) && !empty($theme)){
    echo '<script>theme = "'.$theme[0].'";</script>';
} else {
    echo '<script>theme = 0;</script>';
}

?>
<script src="JS/parametres.js"></script>

<?php 
if ($CHANGE_JS) {
// Changer la variable locales
echo '<script src="JS/parametres.js"></script>';
echo '<script type="text/javascript">',
    'change_font("'.$_POST['polices'].'");',
    '</script>';
} ?>
<?php
include 'MODULES/begin_left.php';
include 'MODULES/end.php';
?>

<div class="middle">
    <form method="POST" enctype="multipart/form-data">
        Police des articles : 
        <select type="text" name="polices" style="min-width:10em;max-height:fit-content;">
            <option value="PT Serif" style="font-family:'Pt Serif';">PT Serif</option>
            <option value="Lato" style="font-family:'Lato';">Lato</option>
            <option value="Kalam" style="font-family:'Kalam';">Kalam</option>
            <option value="Roboto" style="font-family:'Roboto';">Roboto</option>
        </select><br/><br/>
        <input type="submit" name="police" value="Modifier"/>
    </form>
    <br/>
    <h1 align="center">Dark Mode :</h1>
    <div class="element BoutonTransition"><input id="darkTrigger" type="checkbox" class="BoutonTransition"></div>
</div>
<div class="right"></div>

<?php 
// Le bas de l'interface est ajouté après le contenu
include 'tmpl_bottom.php'; 
?>