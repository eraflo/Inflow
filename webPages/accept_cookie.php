<?php
session_start();

setcookie('accept_cookie', true, time() + 60*24*3600, '/', null, false, true);

if(isset($_SERVER['HTTP REFERER']) AND !empty($_SERVER['HTTP_REFERER'])) {
    header('Location: main.php');
} else {
    header('Location: main.php');
}

?>