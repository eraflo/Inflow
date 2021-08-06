            <footer class="footer container">
                <link type="text/css" rel="stylesheet" href="style\footer.css" media="none" onload="if(media!='all')media='all'">
                <noscript><link type="text/css" href="style\footer.css" rel="stylesheet"></noscript>

                <div class="footer_Contact footer_grid_element">
                    <p><b><i>Rejoignez nous !</b></i></p>
                    <a href="https://twitter.com/InflowOfficiel" rel="noreferrer noopener" target="_blank">
                        <img src="assets/twitter.webp"
                        class= "ImageLien noUnderline" loading="lazy" alt="twitter" />
                    </a>
                    <a href="https://www.instagram.com/inflow_officiel/?igshid=1642d7pjo8yi1" rel="noreferrer noopener" target="_blank">
                        <img src="assets/instagram.webp"
                        class= "ImageLien noUnderline" loading="lazy" alt="instagram" />
                    </a>
                    <a href="https://www.facebook.com/Inflow-100173238898216/" rel="noreferrer noopener" target="_blank">
                        <img src="assets/facebook.webp"
                        class= "ImageLien noUnderline" loading="lazy" alt="facebook" />
                    </a>
                    <a href="https://www.twitch.tv/inflowofficiel" rel="noreferrer noopener" target="_blank">
                        <img src="assets/twitch.webp"
                        class= "ImageLien noUnderline" loading="lazy" alt="twitch" />
                    </a>
                    <a href="https://www.youtube.com/channel/UC7cUqgADmD2xV9VDlt6NOXg" rel="noreferrer noopener" target="_blank">
                        <img src="assets/youtube.webp"
                        class= "ImageLien noUnderline" loading="lazy" alt="youtube" />
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
                    <p><a href="Infos.php" id="Infos"></b>Inflow</b></a></p>
                    <p><a href="Infos.php" id="Infos"></b>InflowOfficiel</b></a></p>
                </div>
            </footer>

            <?php if(!isset($_COOKIE['accept_cookie'])) { ?>
                <div class="cookie-alert drop_drop" id="drop_7">En poursuivant votre navigation sur ce site, vous acceptez l'utilisation de cookies pour vous 
                    proposez des contenus et services adaptés à vos centres d'interêt.<br/>
                    <button class="cookie-alert-ok-button" onclick="accept_cookie()">OK</button>
                </div>
            <?php } ?>

        </div>
    </body>
</html>