<?php
function Filtre($texte) {
    $bdd = new PDO("mysql:host=127.0.0.1;dbname=filtre;charset=utf8", "root", "");
    
    $commentaire = $texte;

    $req = $bdd->query('SELECT * FROM filtre');

    $mots = [];
    $rp = [];

    while($m = $req->fetch()) {
        array_push($mots, $m['mot']);
        $r = '';
        for($i=0; $i<strlen($m['mot']); $i++) {
            $r.= '*';
        }

        array_push($rp, $r);
    }

    return $commentaire = str_replace($mots, $rp, strtolower($commentaire));
}
?>