<?php
if(isset($_COOKIE['accept_cookie'])) {
    $showcookie = false;
} else {
    $showcookie = true;
}


?>

<footer class="footer container">
                <?php if($showcookie) { ?>
                <div class="cookie-alert">En poursuivant votre navigation sur ce site, vous acceptez l'utilisation de cookies pour vous 
                proposez des contenus et services adaptés à vos centres d'interêt.<br/><a href="accept_cookie.php">OK</a>
                </div>
                <?php } ?>
                <div style="flex:1;">
                    <p class="element"> Articles et actus sur le rap - <i>Axelito à l'origine</i> - <a href="https://discord.com/channels/826440352810139678/826491405856800788">Rejoignez le Discord !</a></p>
                </div>
                <div class="BoutonTransition"><input id="darkTrigger" type="checkbox" class="BoutonTransition"></div>
            </footer>
        </div>
    </body>
</html>