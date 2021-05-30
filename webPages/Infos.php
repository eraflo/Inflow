<?php
session_start();
$bdd = new PDO("mysql:host=127.0.0.1;dbname=espace_membre;charset=utf8", "root", "");
$bdd2 = new PDO("mysql:host=127.0.0.1;dbname=articles;charset=utf8", "root", "");

$membres2 = $bdd->query('SELECT * FROM membres');
$m = $membres2->fetch();
include 'tmpl_top.php'; 
?>
        <div class="left">
            <div class="navElement"><a href="tmpl_catégories.php?id=3">Rap</a></div>
            <div class="navElement"><a href="tmpl_catégories.php?id=2">Musique Urbaine</a></div>
            <div class="navElement"><a href="tmpl_catégories.php?id=1">Les Chroniques de Jason</a></div>
        </div>
            <!--Début de là où on pourra mettre du texte-->
        <div class="middle">
            <article>
                <!-- <<<<<<< HEAD -->

                <h1 id="Staff">Staff</h1>
                <div class="Plateforme">
                    <div class="liste-équipe">
                        <p><b>PDG </b> : Axel </p>
                        <p><b>Rédacteurs</b> : Elouan, Ilyes, Jason, Maxime, Romane</p>
                        <p><b>Modos</b> : Antoine, Simon, Timothée, Titouan C</p>
                        <p><b>Développeurs</b> : Anyr, Florian, Lucas, Titouan L</p>
                    </div>
                    <div class="liens-sociaux">
                        <h3><i>Insta</i> :</h3>
                        <p><a href="https://instagram.com/inflow_officiel?igshid" target="_blank">Rejoignez notre Instagram !</a></p>
                        <h3><i>Twitter</i> :</h3>
                        <p><a href="https://twitter.com/InflowOfficiel" target="_blank">Rejoignez-nous sur Twitter !</a></p>
                        <h3><i>Twitch</i> :</h3>
                        <p><a href="https://www.twitch.tv/inflowofficiel" target="_blank">Suivez-nous sur Twitch !</a></p>
                        <h3><i>Discord</i> :</h3>
                        <p><a href="https://discord.com/channels/826440352810139678/826491405856800788" target="_blank">Rejoignez le Discord !</a></p>
                    </div>
                </div>
            </article>
        </div>
        <div class="right"></div>
<?php 
// Le bas de l'interface est ajouté après le contenu
include 'tmpl_bottom.php'; 
?>