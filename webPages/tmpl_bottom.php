            <footer class="footer container">
                <link type="text/css" rel="stylesheet" href="style\footer.css" media="none" onload="if(media!='all')media='all'">
                <noscript><link type="text/css" href="style\footer.css" rel="stylesheet"></noscript>

                <div class="footer_Contact footer_grid_element">
                    <p><b><i>Rejoignez nous !</b></i></p>
                    <a href="https://twitter.com/InflowOfficiel" rel="noreferrer noopener" target="_blank">
                        <picture>
                            <source srcset="assets/twitter.webp" type="image/webp" class="ImageLien" loading="lazy" alt="instagram">
                            <img src="assets/twitter.png" type="image/png" class="ImageLien" loading="lazy" alt="instagram">
                        </picture>
                    </a>
                    <a href="https://www.instagram.com/inflow_officiel/?igshid=1642d7pjo8yi1" rel="noreferrer noopener" target="_blank">
                        <picture>
                            <source srcset="assets/instagram.webp" type="image/webp" class="ImageLien" loading="lazy" alt="instagram">
                            <img src="assets/instagram.png" type="image/png" class="ImageLien" loading="lazy" alt="instagram">
                        </picture>    
                    </a>
                    <a href="https://www.facebook.com/Inflow-100173238898216/" rel="noreferrer noopener" target="_blank">
                        <picture>
                            <source srcset="assets/facebook.webp" type="image/webp" class="ImageLien" loading="lazy" alt="instagram">
                            <img src="assets/facebook.png" type="image/png" class="ImageLien" loading="lazy" alt="instagram">
                        </picture>
                    </a>
                    <a href="https://www.twitch.tv/inflowofficiel" rel="noreferrer noopener" target="_blank">
                        <picture>
                            <source srcset="assets/twitch.webp" type="image/webp" class="ImageLien" loading="lazy" alt="instagram">
                            <img src="assets/twitch.png" type="image/png" class="ImageLien" loading="lazy" alt="instagram">
                        </picture>
                    </a>
                    <a href="https://www.youtube.com/channel/UC7cUqgADmD2xV9VDlt6NOXg" rel="noreferrer noopener" target="_blank">
                        <picture>
                            <source srcset="assets/youtube.webp" type="image/webp" class="ImageLien" loading="lazy" alt="instagram">
                            <img src="assets/youtube.png" type="image/png" class="ImageLien" loading="lazy" alt="instagram">
                        </picture>
                    </a>
                </div>
                <div class="footer_Equipe footer_grid_element">
                    <p style="grid-column:span 3"><b><i>L'équipe</i></b></p>
                    <div>
                        <p><b>Programmeurs</b></p>
                        <p>Titouan</p>
                        <p>Florian</p>
                        <p>Lucas</p>
                        <p>Anyr</p>
                        <p>Enzo</p>
                        <p>Timothée</p>
                    </div>
                    <div>
                        <p><b>Chefs de projet</b></p>
                        <p>Axelito</p>
                        <p>Titouan</p>
                    </div>
                    <div>
                        <p><b>Rédacteurs</b></p>
                        <p>Jason</p>
                        <p>Ilyes</p>
                        <p>Romane</p>
                        <p>Elouan</p>
                        <p>Leïla</p>
                    </div>
                </div>
                <div class="footer_Inflow footer_grid_element">
                    <p><a href="Infos.php" id="Infos" class="underline can_rainbow"></b>Inflow</b></a></p>
                    <p><a href="Infos.php" id="Infos" class="underline can_rainbow"></b>InflowOfficiel</b></a></p>
                </div>
            </footer>

            <?php if(!isset($_COOKIE['accept_cookie'])) { ?>
                <div class="cookie-alert drop_drop can_rainbow" id="drop_7">En poursuivant votre navigation sur ce site, vous acceptez l'utilisation de cookies pour vous 
                    proposez des contenus et services adaptés à vos centres d'interêt.<br/>
                    <button class="cookie-alert-ok-button" onclick="accept_cookie()">OK</button>
                </div>
            <?php } ?>

        </div>
    </body>
</html>