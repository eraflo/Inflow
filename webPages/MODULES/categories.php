<?php
// M_ = MODULE
// NÉCESSAIRE POUR LE BON FONCTIONNEMENT DU RESTE DE LA PAGE
// A METTRE A CHAQUE DEBUT DE VARIABLE UTILISE DANS LES MODULES
$M_categories = $bdd->query('SELECT * FROM categories');
?>

<div class="module">
    <?php while($c = $M_categories->fetch()) { ?>
        <a href="tmpl_categories.php?id=<?= $c['id'] ?>" class=""><?= $c['nom'] ?></a>
    <?php } ?>
</div>