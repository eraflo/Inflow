<?php
// Page sur laquelle on va modifier l'article ou la catégorie sélectionnée (pour l'instant seulement l'article)
include 'tmpl_top.php';
include 'MODULES/begin_left.php';
include 'MODULES/end.php';

// Ajouter le contenu de l'article dans l'éditeur de texte Wysibb
$parser->parse($article['contenu']);
$contenu = $parser->getAsHtml();
echo "<script>var bbdata = `".$contenu."`;</script>";
?>
<script src="JS/categories.js" async></script>

<div class="middle">
    <article style="color:black;" id="modification_article">
        <!--Formulaire pour modifier l'article-->
        <form method="POST" enctype="multipart/form-data">
            <input type="text" name="article_titre" value="<?= $article['titre'] ?>" /> <br/>
            <select type="text" name="article_id_auteur">
                <option value="<?= $article['id_auteur'] ?>" style="font-style:italic;"><?= $article['auteur'] ?></option>
                <?php while($a = $auteurs->fetch()) { ?>
                    <option value="<?= $a['id'] ?>"><?= $a['pseudo'] ?></option>
                <?php } ?>
            </select><br/>
            <select id="categorie_selection" type="text" name="article_id_categorie">
                <?php if($article_categorie) { ?><option value="<?= $article['id_categories'] ?>" style="font-style:italic;"><?= $article_categorie ?></option>
                <?php } else { ?><option value="" style="font-style:italic;">Aucune catégorie</option><?php } ?>
                <option value="Nouvelle" style="font-weight:bold;">Nouvelle catégorie</option>
                <?php while($c = $categories->fetch()) { ?>
                    <option value="<?= $c['id'] ?>"><?= $c['nom'] ?></option>
                <?php } ?>
            </select>
            <input id="categorie_name" type="text" name="article_nom_categorie" placeholder="Nom de la catégorie" />
            <input id="categorie_desc" type="text" name="article_desc_categorie" placeholder="Description de la catégorie" /><br/>
            <input type="text" name="article_comment" value="<?= $article['descriptions'] ?>" /> <br/>
            <textarea id="editor" name="article_contenu"></textarea><br/>
            <input type="file" name="miniature"/><br/>
            <input type="submit" value="Modifier l'article" /><br />
        </form>
        <br />
        <!--Affiche message en lien avec le transfert des données du formulaire.
            Ex : 1 des champs n'est pas remplie -> Affiche "Erreur"; Si tout est bien remplie, affiche "Votre article a été posté"-->
        <?php if(isset($message)) { echo $message; } ?>
        <br />
    </article>
    <article id="modification_categorie">
    <!--Formulaire pour modifier la catégorie-->
    </article>
</div>