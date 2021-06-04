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
if (!isset($_COOKIE["last_visit"])) {
    setcookie("last_visit", time(), time()+3600, '/', null, false, true); // expire en 1h
    $M_compte++;
    fseek($M_compteur_f, 0);
    fputs($M_compteur_f, $M_compte);
}

fclose($M_compteur_f);
?>
