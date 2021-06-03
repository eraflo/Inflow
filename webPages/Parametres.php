
<?php // Page de paramètres modifiables par l'utilisateur
session_start();
$bdd = new PDO("mysql:host=127.0.0.1;dbname=inflow;charset=utf8", "root", "");



if(isset($_POST['police'])) {
    // Importer le script avant de l'excecuter
    echo '<script src="JS/parametres.js"></script>';
    echo '<script type="text/javascript">',
        'change_font("'.$_POST['police'].'");',
        '</script>';
}

include 'tmpl_top.php';
?>
<script src="JS/parametres.js"></script>

<?php
include 'MODULES/begin_left.php';
include 'MODULES/profil.php';
include 'MODULES/end.php';
?>

<div class="middle">
    <form method="POST" enctype="multipart/form-data">
        Police des articles : 
        <select type="text" name="police" style="min-width:10em;max-height:fit-content;">
            <option value="PT Serif" style="font-family:'Pt Serif';">PT Serif</option>
            <option value="Lato" style="font-family:'Lato';">Lato</option>
            <option value="Kalam" style="font-family:'Kalam';">Kalam</option>
            <option value="Roboto" style="font-family:'Roboto';">Roboto</option>
        </select><br/><br/>
        <input type="submit" value="Modifier"/>
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