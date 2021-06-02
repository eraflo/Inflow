
<?php // Page de paramètres modifiables par l'utilisateur
session_start();
$bdd = new PDO("mysql:host=127.0.0.1;dbname=inflow;charset=utf8", "root", "");

// Importer le script avant de l'excecuter
echo '<script src="JS/parametres.js"></script>';

if(isset($_POST['police'])) {
    echo '<script type="text/javascript">',
        'change_font("'.$_POST['police'].'");',
        '</script>';
}

include 'tmpl_top.php';
?>
<script src="JS/parametres.js"></script>

<?php
include 'LEFT/begin.php';
include 'LEFT/end.php';
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
</div>
<div class="right"></div>

<?php 
// Le bas de l'interface est ajouté après le contenu
include 'tmpl_bottom.php'; 
?>