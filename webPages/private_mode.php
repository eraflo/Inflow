<?php
session_start();
$bdd = new PDO("mysql:host=127.0.0.1;dbname=inflow;charset=utf8", "root", "");
$statut_compte = $bdd->prepare('SELECT prive FROM membres WHERE id = ?');
$statut_compte->execute(array($_SESSION['id']));
$statut_compte = $statut_compte->fetch();
$statut_compte = $statut_compte[0];
if($statut_compte == 0) {
    $req_priv = $bdd->prepare('UPDATE membres SET prive = 1 WHERE id = ?');
    $req_priv->execute(array($_SESSION['id']));
} elseif($statut_compte == 1) {
    $req_priv = $bdd->prepare('UPDATE membres SET prive = 0 WHERE id = ?');
    $req_priv->execute(array($_SESSION['id']));
}

?>