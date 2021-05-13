import textract
lien = "C:\\Users\\titlo\\Documents\\cours\\Terminale\\NSI\\jeu_de_la_vie\\jeudelavie_titouan.txt"

def traitement(fichier):
    assert type(fichier)==str, 'erreur'
    # on recupere un str code en utf-8 avec differentes methodes
    if fichier.endswith(".pdf"):
        text = textract.process(
            fichier,
            method='pdftotext',
            encoding="utf_8"
            )
    elif fichier.endswith(".docx") or fichier.endswith(".odt"):
        text = textract.process(
        fichier,
        encoding="utf_8"
        )
    # on le decode
    texte = text.decode(encoding="utf-8",errors="strict")
    # on renvoie le texte decode
    return texte


print(traitement(lien))
