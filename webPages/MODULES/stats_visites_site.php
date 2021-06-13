<?php
    $M_compteur_f = fopen('compteur_visites.txt', 'r');
    $M_compte = fgets($M_compteur_f);
    fclose($M_compteur_f);

    $temps_session = 30;
    $temps_actuel = date("U");
    $ip_user = $_SERVER['REMOTE_ADDR'];

    $req_ip_exist = $bdd->prepare('SELECT * FROM onlines WHERE user_ip = ? ');
    $req_ip_exist->execute(array($ip_user));
    $ip_exist = $req_ip_exist->rowCount();

    if($ip_exist == 0) {
        $add_ip = $bdd->prepare('INSERT INTO onlines (user_ip, Timess) VALUES(?, ?)');
        $add_ip->execute(array($ip_user, $temps_actuel));
    } else {
        $update_ip = $bdd->prepare('UPDATE onlines SET Timess = ? WHERE user_ip = ?');
        $update_ip->execute(array($temps_actuel, $ip_user));
    }

    $session_delete_time = $temps_actuel - $temps_session;

    $del_ip = $bdd->prepare('DELETE FROM onlines WHERE Timess < ?');
    $del_ip->execute(array($session_delete_time));

    $show_user_nbr = $bdd->query('SELECT * FROM onlines');
    $user_nbr = $show_user_nbr->rowCount();
?>

<div class="module Visites">
    <p><b class="PTitle can_rainbow">Statistiques:</b><br /><b>Total:</b> <i></<?php echo '<strong>'.$M_compte.'</strong> visites.'; ?></i><br /><b>Aujourd'hui:</b>...<br /><b>En ce moment:</b> <?php echo $user_nbr ?> </p>
</div>
