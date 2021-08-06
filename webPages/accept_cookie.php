<?php
session_start();

setcookie('accept_cookie', true, time() + 60*24*3600, '/', null, false, true);

?>
