<?php
    $M_compteur_f = fopen('compteur_visites.txt', 'r');
    $M_compte = fgets($M_compteur_f);
    fclose($M_compteur_f);
?>

<div class="module Visites">
    <p><b class="PTitle">Statistiques:</b><br /><b>Total:</b> <i></<?php echo '<strong>'.$M_compte.'</strong> visites.'; ?></i><br /><b>Aujourd'hui:</b>...<br /><b>En ce moment:</b>...</p>
</div>
