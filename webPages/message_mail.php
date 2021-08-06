<?php
$header = "MIME-Version: 1.0\r\n";
$header .= 'From: Inflow.com <inflow.contact@gmail.com>'."\n";
$header .= 'Content-Type:text/html; charset="utf-8"'."\n";
$header .= 'Content-Transfert-Encoding: 8bit';

$message = '
<html>
<head>
    <title>Récupération de mot de passe - Inflow.com</title>
    <meta charset="utf-8" />
</head>
<body>
    <font color="#303030";>
        <div align="center">
            <table width="600px">
                <tr>
                    <td background="assets/banniere_twi.webp" height="100px"></td>
                </tr>
                <tr>
                    <td>
                        <br/>
                        <div align="center">Bonjour <b>'.$pseudo.'</b>,</div><br/>
                        Voici votre code de récupération : <b>'.$recup_code.'</b><br/><br/>
                        A bientôt sur < href="main.php">Inflow.com</a> !<br/>
                        <br/><br/><br/><br/>
                    </td>
                </tr>
                <tr>
                    <td align="center">
                        <font size="2">
                            Ceci est un email automatique, merci de ne pas y répondre
                        </font>
                    </td>
                </tr>
            </table>
        </div>
    </font>
</body>
</html>
';

mail($recup_mail, "Récupération de mot de passe - Inflow.com", $message,  $header);
header("Location: recuperation.php?section=code&rm=$recup_mail");

?>