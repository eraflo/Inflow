<?php
session_start();
$bdd = new PDO("mysql:host=127.0.0.1;dbname=articles;charset=utf8", "root", "");
$bdd2 = new PDO("mysql:host=127.0.0.1;dbname=espace_membre;charset=utf8", "root", "");

if(isset($_GET['user'])) {
    $research = (String) trim($_GET['user']);

    $req = $bdd->query('SELECT * FROM articles WHERE titre LIKE "%'.$research.'%" LIMIT 3');
    $req = $req->fetchAll();

    $req1 = $bdd->query('SELECT * FROM articles WHERE contenu LIKE "%'.$research.'%" LIMIT 3');
    $req1 = $req1->fetchAll();

    $req2 = $bdd2->query('SELECT * FROM membres WHERE pseudo LIKE "%'.$research.'%" LIMIT 3');
    $req2 = $req2->fetchAll();

    if(!empty($req)) {
            foreach($req as $r) {
                ?>
                    <div>
                    <a href="Publication.php?id=<?= $r['id'] ?>">
                        <?= $r['titre'] ?>
                    </a>
                    </div>
                <?php
            }
        } elseif(!empty($req1)) {
            foreach($req1 as $r) {
                ?>
                    <div>
                        <a href="Publication.php?id=<?= $r['id'] ?>">
                            <?= $r['titre'] ?>
                        </a>
                    </div>
                <?php
        }
    } 
    if(!empty($req2)) {
        foreach($req2 as $r) {
            ?>
                <div>
                    <a href="Profil.php?id=<?= $r['id'] ?>">
                        <?= $r['pseudo'] ?>
                    </a>
                </div>
            <?php
        }
    }      
}
?>