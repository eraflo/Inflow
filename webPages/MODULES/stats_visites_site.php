<?php
    $M_compteur_f = fopen('compteur_visites.txt', 'r');
    $M_compte = fgets($M_compteur_f);
    fclose($M_compteur_f);
?>

<div class="module">
    <p><?php echo '<strong>'.$M_compte.'</strong> visites.'; ?></p>
</div>
