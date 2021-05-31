<?php 
    $categories = $bdd->query('SELECT * FROM categories');
?>

<div class="module">
    <?php while($c = $categories->fetch()) { ?>
        <a href="tmpl_categories.php?id=<?= $c['id'] ?>" class=""><?= $c['nom'] ?></a>
    <?php } ?>
</div>