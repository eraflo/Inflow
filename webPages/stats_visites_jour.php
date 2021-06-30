<?php

$delete = $bdd->query("DELETE FROM compteur_jour WHERE date_visite <> DATE(NOW())");


// On effectue une recherche pour savoir si l'IP est déjà enregistrée.

$IP_exist = $bdd->prepare('SELECT * FROM compteur_jour WHERE date_visite = DATE(NOW()) AND ip = ?');
$IP_exist->execute(array($_SERVER['REMOTE_ADDR']));

// On vérifie l'ip

if($ip = $IP_exist->rowCount() < 1) {
    // On insère l'ip si elle n'existe pas.
    $insert = $bdd->prepare("INSERT INTO compteur_jour (ip, date_visite) VALUES(?, DATE(NOW()))");
    $insert->execute(array($_SERVER['REMOTE_ADDR']));
}


// On récupère la valeur du compteur

$select = $bdd->query("SELECT * FROM compteur_jour WHERE date_visite = DATE(NOW())");
$compt = $select->rowCount();

?>