<?php
    // ML = MODULE LEFT
    // NÉCESSAIRE POUR LE BON FONCTIONNEMENT DU RESTE DE LA PAGE
    // A METTRE A CHAQUE DEBUT DE VARIABLE UTILISE DANS LES MODULES
    $ML_categories = $bdd->query('SELECT * FROM categories');
?>

<div class="module">
    <?php while($c = $ML_categories->fetch()) { ?>
        <a href="tmpl_categories.php?id=<?= $c['id'] ?>" class=""><?= $c['nom'] ?></a>
    <?php } ?>
</div>