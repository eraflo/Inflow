<?php
session_start();
$bdd = new PDO("mysql:host=127.0.0.1;dbname=inflow;charset=utf8", "root", "");

if(isset($_GET['t'], $_GET['id'], $_SESSION['id'], $_SESSION) AND !empty($_GET['t']) AND !empty($_GET['id']) AND !empty($_SESSION['id'])) {
    $getid = (int) $_GET['id'];
    $gett = (int) $_GET['t'];

    $sessionid = $_SESSION['id'];

    $check = $bdd->prepare('SELECT id FROM articles WHERE id = ?');
    $check->execute(array($getid));
    $nbre_like = $bdd->prepare('SELECT nombre_like FROM articles WHERE id = ?');
    $nbre_like->execute(array($getid));
    $nb_l = $nbre_like->fetch();

    if($check->rowCount() == 1) {
        if($gett == 1) {
            $check_like = $bdd->prepare('SELECT id FROM likes WHERE id_article = ? AND id_membre = ?');
            $check_like->execute(array($getid, $sessionid));

            $del = $bdd->prepare('DELETE FROM dislikes WHERE id_article = ? AND id_membre = ?');
            $del->execute(array($getid, $sessionid));

            if($check_like->rowCount() == 1) {
                $del = $bdd->prepare('DELETE FROM likes WHERE id_article = ? AND id_membre = ?');
                $del->execute(array($getid, $sessionid));
                $del2 = $bdd->prepare('UPDATE articles SET nombre_like = ? WHERE id = ?');
                $del2->execute(array(((INT)$nb_l[0] - 1), $getid));
            } else {
                $ins = $bdd->prepare('INSERT INTO likes (id_article, id_membre) VALUES (?, ?)');
                $ins->execute(array($getid, $sessionid));
                $ins2 = $bdd->prepare('UPDATE articles SET nombre_like = ? WHERE id = ?');
                $ins2->execute(array(((INT)$nb_l[0] + 1), $getid));
            }
        } elseif($gett == 2) {
            $check_dislike = $bdd->prepare('SELECT id FROM dislikes WHERE id_article = ? AND id_membre = ?');
            $check_dislike->execute(array($getid, $sessionid));

            $del = $bdd->prepare('DELETE FROM likes WHERE id_article = ? AND id_membre = ?');
            $del->execute(array($getid, $sessionid));
            $del2 = $bdd->prepare('UPDATE articles SET nombre_like = ? WHERE id = ?');
            $del2->execute(array(((INT)$nb_l[0] - 1), $getid));

            if($check_dislike->rowCount() == 1) {
                $del = $bdd->prepare('DELETE FROM dislikes WHERE id_article = ? AND id_membre = ?');
                $del->execute(array($getid, $sessionid));
            } else {
                $ins = $bdd->prepare('INSERT INTO dislikes (id_article, id_membre) VALUES (?, ?)');
                $ins->execute(array($getid, $sessionid));
            }
        }
        header('Location: Publication.php?id='.$getid);
    } else {
        header('Location: main.php');
    }
} else {
    header('Location: main.php');
}

?>