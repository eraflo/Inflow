<?php
// On récupère la date du jour.

$now_Y = date("Y");
$now_m = date("m");
$now_d = date("d");
$date  = "$now_d-$now_m-$now_Y";

$ip_User = $_SERVER['REMOTE_ADDR'];

// On efface les IP qui sont "périmées" (date actuelle différente des dates précédentes)

$delete = $bdd->prepare("DELETE FROM compteur_jour WHERE date_visite <> ? ");
$delete->execute(array($date));

// On effectue une recherche pour savoir si l'IP est déjà enregistrée.

$IP_exist = $bdd->query("SELECT * FROM compteur_jour WHERE date_visite = '.$date.'");


// On vérifie l'ip
while($ip = $IP_exist->fetch()) {
    if($ip['ip'] != $ip_User)
    {

    // On insère l'ip si elle n'existe pas.

    $insert = $bdd->prepare("INSERT INTO compteur_jour (ip, date_visite) VALUES(?, ?)");
    $insert->execute(array($ip_User, $date));

    }
}

// On récupère la valeur du compteur

$select = $bdd->query("SELECT ip FROM compteur_jour WHERE date_visite = '$date'");
$compt = $select->rowCount();

?>