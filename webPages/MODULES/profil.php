<?php
// M_ = MODULE
// NÉCESSAIRE POUR LE BON FONCTIONNEMENT DU RESTE DE LA PAGE
// A METTRE A CHAQUE DEBUT DE VARIABLE UTILISE DANS LES MODULES
if(isset($_SESSION['id']) && ($_SESSION['id'] > 0)) {
    $M_requser = $bdd->prepare('SELECT * FROM membres WHERE id = ?');
    $M_requser->execute(array($_SESSION['id']));
    $M_userinfos = $M_requser->fetch();
?>
<?php if(!empty($M_userinfos['avatar'])) { ?>
    <img src="membres/avatars/<?php echo $M_userinfos['avatar']; ?>" class="avatar hcenter" style="max-width:7em;">
<?php } ?>
<b><a href="Profil.php?id=<?= $M_userinfos['id'] ?>"><?php echo $M_userinfos['pseudo']; ?></a></b>
<a href="historique.php"><div class="PActions"><i>Historique </i></div></a>
<a href="editionprofil.php"><div class="PActions"><i>Editer mon profil </i></div></a>
<a href="deconnexion.php"><div class="PActions">Se déconnecter</div></a>
<?php } ?>