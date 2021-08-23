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
</head>
<div class="middle">
    <article class="ProfilTxt" id="modification_categorie">
        <!--Formulaire pour postez des articles-->
        <form method="POST" enctype="multipart/form-data" class="con_ins">
            <input class="input_form" type="text" name="categorie_nom" value="<?= $categorie['nom'] ?>" />
            <select class="input_form" type="text" name="categorie_auteur" placeholder="Auteur">
                <option value="<?= $categorie['auteur'] ?>" style="font-style:italic;"><?= $categorie['auteur'] ?></option>
                <?php while($a = $auteurs->fetch()) { ?>
                    <option value="<?= $a['pseudo'] ?>"><?= $a['pseudo'] ?></option>
                <?php } ?>
            </select><br/>
            <div style="text-align:initial;">
                <textarea class="input_form" id="editor" name="categorie_description" placeholder="Description de la categorie">
                    <?php if(!empty($categorie['description'])){echo str_replace(array("<br />", "<br/>", "<br >", "<br>"), '', $categorie['description']);} ?>
                </textarea>
            </div><br/>
            <?php if(isset($categorie['avatar_categorie']) && !empty($categorie['avatar_categorie'])){ ?>
                <img width="90%" src="membres/avatars_categorie/<?= $categorie['avatar_categorie'] ?>" /><br/>
            <?php } ?>
            <label class="Titre_form" for="miniature_categorie">Miniature : </label><input class="input_form" type="file" name="miniature_categorie"/><br/>
            <input class="input_form" type="submit" value="Modifier la catégorie" /><br />
        </form>
        <br />
        <!--Affiche message en lien avec le transfert des données du formulaire.
            Ex : 1 des champs n'est pas remplie -> Affiche "Erreur"; Si tout est bien remplie, affiche "Votre article a été posté"-->
        <?php if(isset($message)) { echo $message; } ?>
        <a class="underline" href="Publication.php?id=<?=$get_id?>">Retour à l'article</a>
        <br />
    </article>
</div>
