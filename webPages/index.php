<?php
session_start();
$bdd = new PDO("mysql:host=127.0.0.1;dbname=inflow;charset=utf8", "root", "");

if(!isset($_SESSION['admin']) OR $_SESSION['admin'] != 1 OR !isset($_SESSION)) {
    header("Location: main.php");
}
?>

    <!DOCTYPE html>
    <html>

    <head>
        <title>Redirection vers le site</title>
        <meta http-equiv="refresh" content="0; URL=main.php">
    </head>

    </html>