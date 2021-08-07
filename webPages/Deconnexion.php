<?php
session_start();
$_SESSION = array();
session_destroy();
?>

<script type="text/javascript">
    window.localStorage.clear();
    window.location="Connexion.php";
</script>
