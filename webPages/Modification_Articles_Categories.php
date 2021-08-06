<?php
// Page sur laquelle on va modifier l'article ou la catégorie sélectionnée (pour l'instant seulement l'article)
include 'tmpl_top.php';
include 'MODULES/begin_left.php';
include 'MODULES/end.php';

?>
<head>
<!--Charger ressources pour éditeur de texte-->
    <!--Trumbowyg resources-->
    <link rel="stylesheet" href="JS/trumbowyg/ui/trumbowyg.min.css" media="none" onload="if(media!='all')media='all'">
    <noscript><link href="JS/trumbowyg/ui/trumbowyg.min.css" rel="stylesheet"></noscript>
    <script type="text/javascript" src="JS/trumbowyg/trumbowyg.min.js" defer></script>
    <script type="text/javascript" src="JS/trumbowyg/langs/fr.js" defer></script>
    <!--Plugins for Trumbowyg-->
    <script src="JS/trumbowyg/plugins/pasteembed/trumbowyg.pasteembed.min.js" defer></script>
    <script src="JS/trumbowyg/plugins/pasteimage/trumbowyg.pasteimage.min.js" defer></script>
    <script src="JS/trumbowyg/plugins/history/trumbowyg.history.min.js" defer></script>
    <script src="JS/trumbowyg/plugins/resizimg/trumbowyg.resizimg.min.js" defer></script>
    <script src="JS/trumbowyg/plugins/resizimg/jquery-resizable.min.js" defer></script>
    <script src="JS/trumbowyg/plugins/colors/trumbowyg.colors.min.js" defer></script>
    <link rel="stylesheet" href="JS/trumbowyg/plugins/colors/ui/trumbowyg.colors.min.css">
    <!--Init Trumbowyg-->
    <script type="text/javascript" src="JS/trumbowyg/trumbowyg.js" defer></script>

    <script src="JS/categories.js" defer></script>
</head>
<div class="middle">
    <article class="ProfilTxt" id="modification_article">
        <!--Formulaire pour postez des articles-->
        <form method="POST" enctype="multipart/form-data" class="con_ins">
            <input class="input_form" type="text" name="article_titre" value="<?= $article['titre'] ?>" />
            <select class="input_form" type="text" name="article_id_auteur" placeholder="Auteur">
                <option value="<?= $article['id_auteur'] ?>" style="font-style:italic;"><?= $article['auteur'] ?></option>
                <?php while($a = $auteurs->fetch()) { ?>
                    <option value="<?= $a['id'] ?>"><?= $a['pseudo'] ?></option>
                <?php } ?>
            </select><br/>
            <select class="input_form" id="categorie_selection" type="text" name="article_id_categorie">
                <?php if($article_categorie) { ?>
                    <option value="<?= $article['id_categories'] ?>" style="font-style:italic;"><?= $article_categorie ?></option><?php } ?>
                    <option value="" style="font-style:italic;">Aucune catégorie</option>
                    <option value="Nouvelle" style="font-weight:bold;">Nouvelle catégorie</option>
                <?php while($c = $categories->fetch()) { ?>
                    <option value="<?= $c['id'] ?>"><?= $c['nom'] ?></option>
                <?php } ?>
            </select><br/>
            <input class="input_form" id="categorie_name" type="text" name="article_nom_categorie" placeholder="Nom de la catégorie" />
            <input class="input_form" id="categorie_desc" type="text" name="article_desc_categorie" placeholder="Description de la catégorie" /><br/>
            <textarea class="input_form" type="text" name="article_comment" placeholder="Description" style="resize:vertical;width:100%"><?= $article['descriptions'] ?></textarea><br/>
            <div style="text-align:initial;">
                <textarea class="input_form" id="editor" name="article_contenu" placeholder="Contenu de l'article">
                    <?php if(isset($contenu)){echo str_replace(array("<br />", "<br/>", "<br >", "<br>"), '', $contenu);} ?>
                </textarea>
            </div><br/>
            <label class="Titre_form" for="miniature">Miniature : </label><input class="input_form" type="file" name="miniature"/><br/>
            <input class="input_form" type="submit" value="Modifier l'article" /><br />
        </form>
        <br />
        <!--Affiche message en lien avec le transfert des données du formulaire.
            Ex : 1 des champs n'est pas remplie -> Affiche "Erreur"; Si tout est bien remplie, affiche "Votre article a été posté"-->
        <?php if(isset($message)) { echo $message; } ?>
        <br />
    </article>
</div>
