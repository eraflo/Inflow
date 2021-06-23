
// Script pour customiser éditeur de texte pour articles
$(function() { var Options = {
    buttons: "bold,italic,underline,strike,|,sup,sub,|,img,video,link,|,bullist,numlist,|,\fontcolor,\
    fontsize,fontfamily,|,justifyleft,justifycenter,justifyright,|,quote,code,table,removeFormat",
    lang: "fr" }
$("#editor").wysibb(Options);
if (typeof(bbdata) != "undefined") {
    $("#editor").insertAtCursor(bbdata);
}
})
