<?php
session_start();
$bdd = new PDO("mysql:host=127.0.0.1;dbname=inflow;charset=utf8", "root", "");

include 'stats_visites_site.php';

$membres2 = $bdd->query('SELECT * FROM membres');
$m = $membres2->fetch();
include 'tmpl_top.php';
?>
            <?php
            include 'MODULES/begin_left.php';
            include 'MODULES/categories.php';
            include 'MODULES/end.php';
            ?>
        <!--Début de là où on pourra mettre du texte-->
        <div class="middle">
            <article class="À-Refaire">
                <!-- <<<<<<< HEAD -->

                <h1 id="Staff">Staff</h1>
                <div>
                    <div>
                        <p><b>PDG </b> : Axel </p>
                        <p><b>Rédacteurs</b> : Elouan, Ilyes, Jason, Maxime, Romane</p>
                        <p><b>Modos</b> : Antoine, Simon, Timothée, Titouan C</p>
                        <p><b>Développeurs</b> : Anyr, Florian, Lucas, Titouan L</p>
                    </div>
                    <div>
                        <h3><i>Insta</i> :</h3>
                        <p><a href="https://instagram.com/inflow_officiel?igshid" rel="noreferrer noopener">Rejoignez notre Instagram !</a></p>
                        <h3><i>Twitter</i> :</h3>
                        <p><a href="https://twitter.com/InflowOfficiel" rel="noreferrer noopener">Rejoignez-nous sur Twitter !</a></p>
                        <h3><i>Twitch</i> :</h3>
                        <p><a href="https://www.twitch.tv/inflowofficiel" rel="noreferrer noopener">Suivez-nous sur Twitch !</a></p>
                        <h3><i>Discord</i> :</h3>
                        <p><a href="https://discord.com/channels/826440352810139678/826491405856800788" rel="noreferrer noopener">Rejoignez le Discord !</a></p>
                    </div>
                </div>
            </article>
        </div>
        <div class="right"></div>
<?php 
// Le bas de l'interface est ajouté après le contenu
include 'tmpl_bottom.php'; 
?>