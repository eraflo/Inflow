<?php
if(file_exists('compteur_visites.txt'))
{
        $M_compteur_f = fopen('compteur_visites.txt', 'r+');
        $M_compte = fgets($M_compteur_f);
}
else
{
        $M_compteur_f = fopen('compteur_visites.txt', 'a+');
        $M_compte = 0;
}
if(!isset($_SESSION['compteur_de_visite']))
{
        $_SESSION['compteur_de_visite'] = 'visite';
        $M_compte++;
        fseek($M_compteur_f, 0);
        fputs($M_compteur_f, $M_compte);
}
fclose($M_compteur_f);
?>

<div class="module">
<p><?php echo '<strong>'.$M_compte.'</strong> visites.'; ?></p>
</div>
