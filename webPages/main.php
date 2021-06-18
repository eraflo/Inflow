<?php
session_start();
$bdd = new PDO("mysql:host=127.0.0.1;dbname=inflow;charset=utf8", "root", "");


$search_auteur = $bdd->prepare('SELECT * FROM `membres` WHERE id = ?');
$recom = $bdd->query('SELECT * FROM `articles` ORDER BY nombre_like DESC LIMIT 6');

include 'stats_visites_site.php';

// Le haut de l'interface est ajouté avant le contenu
include 'tmpl_top.php';
?>
<?php
include 'MODULES/begin_left.php';
include 'MODULES/categories.php';
include 'MODULES/stats_visites_site.php';
include 'MODULES/end.php';
?>
<!--Début de là où on pourra mettre du texte-->
<div class="middle">
    <article class="ProfilTxt MenuTxt">
        <h1> Qui sommes nous ? </h1>
        <p, style="font-family: sans-serif;"> Inflow est un média musical entièrement géré par des lycéens dont le but est 
            de faire découvrir la musique urbaine à nos lecteurs, qu'ils soient néophytes ou expérimentés.<br /><br />
            L'équipe d'Inflow vous souhaite une bonne lecture et une bonne écoute !<br /><br /><br />
        </p>

        <h1>Recommandations :</h1>
        <!--Affiche des recommendations d'articles à lire-->
        <div class="articleRecommendationGallery articleGallery hcenter">
            <?php while($a_r = $recom->fetch()) { 
                ?>
                <a href="Publication.php?id=<?= $a_r['id'] ?>" class="noUnderline cardArticleContainer">
                <?php if(!empty($a_r['avatar_article'])) { ?>
                    <img class="cardArticleImage" src="membres/avatars_article/<?php echo $a_r['avatar_article']; ?>" href="Publication.php?id=<?= $a_r['id'] ?>" style="width:100%;" loading="lazy"/>
                <?php } ?>
                    <div class="cardArticleContent">
                        <p class="cardArticleTitle"><?= $a_r['titre'] ?></p>
                        <p class="cardArticleMainText"><?= $a_r['descriptions'] ?></p>
                        <?php 
                        if(isset($a_r['id_auteur']) AND $a_r['id_auteur'] != NULL) {
                            $search_auteur->execute(array($a_r['id_auteur'])); 
                            $sa1 = $search_auteur->fetch();?>
                            <p class="cardArticleSecondaryText"> <?= $sa1['pseudo'] ?></p>
                            <?php } else { ?>
                                <p class="cardArticleSecondaryText"> <?= $a_r['auteur'] ?></p>
                            <?php } ?>
                    </div>
                </a>
            <?php } ?>
        </div>
                    
        <br/><p> Pour nous suivre sur tous nos réseaux: </p>
        <a href="https://twitter.com/InflowOfficiel" target="_blank">
            <img src="https://cdn.discordapp.com/attachments/821777182790647869/851523241100050493/unknown.png"
            class= "ImageLien noUnderline" loading="lazy" rel="noreferrer noopener" />
        </a>
        <a href="https://www.instagram.com/inflow_officiel/?igshid=1642d7pjo8yi1" target="_blank">
            <img src="https://cdn.discordapp.com/attachments/821777182790647869/851526078144184330/unknown.png"
            class= "ImageLien noUnderline" loading="lazy" rel="noreferrer noopener" />
        </a>
        <a href="https://www.facebook.com/Inflow-100173238898216/" target="_blank">
            <img src="https://cdn.discordapp.com/attachments/821777182790647869/851522746550059018/unknown.png"
            class= "ImageLien noUnderline" loading="lazy" rel="noreferrer noopener" />
        </a>
        <a href="https://www.twitch.tv/inflowofficiel" target="_blank">
            <img src="https://cdn.discordapp.com/attachments/821777182790647869/851522214628294746/unknown.png"
            class= "ImageLien noUnderline" loading="lazy" rel="noreferrer noopener" />
        </a>
        <a href="https://www.youtube.com/channel/UC7cUqgADmD2xV9VDlt6NOXg" target="_blank">
            <img src="https://th.bing.com/th/id/Re452148fe022416aa3ef036f26036222?rik=g055Rpswucg8jA&riu=http%3a%2f%2fgetdrawings.com%2fvectors%2fyoutube-logo-square-vector-36.png&ehk=N9REe%2bS92%2bYUxfCg8a0FNrCgmB96y1GyNtPDYNU5ldE%3d&risl=&pid=ImgRaw"
            class= "ImageLien noUnderline" loading="lazy" rel="noreferrer noopener" />
        </a>
    </article>
</div>
<div class="right"></div>
<?php 
// Le bas de l'interface est ajouté après le contenu
include 'tmpl_bottom.php'; 
?>