<?php
// M_ = MODULE
// NÉCESSAIRE POUR LE BON FONCTIONNEMENT DU RESTE DE LA PAGE
// A METTRE A CHAQUE DEBUT DE VARIABLE UTILISE DANS LES MODULES
if(isset($_SESSION['id']) && ($_SESSION['id'] > 0)) {
    $M_requser = $bdd->prepare('SELECT * FROM membres WHERE id = ?');
    $M_requser->execute(array($_SESSION['id']));
    $M_userinfos = $M_requser->fetch();
?>
<div class="module">
    <?php if(!empty($M_userinfos['avatar'])) { ?>
        <img src="membres/avatars/<?php echo $M_userinfos['avatar']; ?>" class="avatar" style="max-width:7em;">
    <?php } ?>
    <b><a href="Profil.php?id=<?= $M_userinfos['id'] ?>"><?php echo $M_userinfos['pseudo']; ?></a></b>
    <i><span><?php echo $M_userinfos['biographie']; ?></span></i><br/>
    <a href="Déconnexion.php"><div class="PActions">Se déconnecter</div></a>
</div>
<?php } ?>