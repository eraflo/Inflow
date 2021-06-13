<?php
// M_ = MODULE
// NÉCESSAIRE POUR LE BON FONCTIONNEMENT DU RESTE DE LA PAGE
// A METTRE A CHAQUE DEBUT DE VARIABLE UTILISE DANS LES MODULES
$M_categories = $bdd->query('SELECT * FROM categories');
?>

<div class="module" style="border-top: solid;border-color: var(--color-text);border-width: 0.5px;">
    <b class="PTitle can_rainbow"><br />Catégories:</b>
    <?php while($c = $M_categories->fetch()) { ?>
        <a href="tmpl_categories.php?id=<?= $c['id'] ?>" class=""><i><?= $c['nom'] ?></i></a>
    <?php } ?>
</div>