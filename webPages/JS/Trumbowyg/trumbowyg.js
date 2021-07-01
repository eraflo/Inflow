
// Utilisé pour instancier l'éditeur de texte avec ses paramètres

$('#editor').trumbowyg({
    removeformatPasted: true,
    autogrow: true,
    urlProtocol: true,
    defaultLinkTarget: '_blank',
    lang: 'fr',
    minimalLinks: true,
    plugins: {
        // Add imagur parameters to upload plugin for demo purposes
        upload: {
            serverPath: 'https://api.imgur.com/3/image',
            fileFieldName: 'image',
            headers: {
                'Authorization': 'Client-ID 9043ee75e1b0950'
            },
            urlPropertyName: 'data.link'
        }
    },
    btns: [
        ['viewHTML'],
        ['historyUndo', 'historyRedo'],
        ['formatting'],
        ['strong', 'em', 'del', 'underline'],
        ['superscript', 'subscript'],
        ['justifyLeft', 'justifyCenter', 'justifyRight', 'justifyFull'],
        ['unorderedList', 'orderedList'],
        ['link'],
        ['insertImage'],
        ['foreColor', 'backColor'],
        ['horizontalRule'],
        ['fullscreen']
    ]
});
