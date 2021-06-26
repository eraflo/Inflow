hey = """----------------------------------------------------------------------------------
                              Anyr Bagui juin 2021
                 Tentative de css et js et peut-être html minifier
----------------------------------------------------------------------------------
Étapes :
 - supprimer les tabulations
 - supprimer les espaces au début et à la fin des lignes
 - supprimer les retours à la ligne
 - supprimer les commentaires dans le code
 - supprimer les espaces doubles, ou avant/après certains caractères
     { , ; :
 - RENOMMER les variables utilisées dans le code 
     (css seulement, --exemple1 --exemple2 ... vont devenir --a --b ...)"""
help = """----------------------------------------------------------------------------------
Utilisation :

    (python) minifier.py [input] [output]

 - L'input est obligatoire, doit être un fichier lisible (texte)
 - L'output est facultatif, doit être le nom du fichier pour la création d'un
     nouveau fichier (ou d'écrasement du fichier déjà existant) ou alors doit
     avoir la valeur "overwrite", cela va écraser le fichier existant

"""

# ----------------------------------------------------------

import sys

# ----------------------------------------------------------
mode = None
l_args = len(sys.argv)
if "-help" in sys.argv:
    print(hey)
    print(help)
    exit()
if l_args <= 1:
    print("\n\nmissing file to minify\n\n".upper())
    print(help)
    exit()
elif l_args == 2:
    mode = "read"
    file_to_read = sys.argv[1]
elif l_args == 3:
    mode = "read-write"
    file_to_read = sys.argv[1]
    if "overwrite" in sys.argv[2]:
        file_to_write = file_to_read
    else:
        file_to_write = sys.argv[2]
elif l_args > 3:
    print("\n\ntoo much arguments\n\n".upper())
    print(help)
    exit()

# ----------------------------------------------------------
print("Lecture du fichier", file_to_read)

with open(file_to_read, 'r') as file:
    data = file.read()
text = str(data)

# ----------------------------------------------------------

def remove_tabs(text):
    text = text.replace("\t", "")
    return text

def remove_star_end_spaces_newlines(text):
    split = text.split("\n")
    temp = ""
    for line in split:
        if len(line) != 0:
            while (line[0] == " ") or (line[0] == "\t"):
                line = line[1:]
            while (line[-1] == " ") or (line[-1] == "\t"):
                line = line[:-1]
            temp += line
    text = temp
    return text

def remove_comments(text):
    while "/*" in text:
        start = text.index("/*")
        end = text.index("*/")
        text = text[:start] + text[end+2:]
    return text

def remove_spaces(text):
    def is_in_quotes(text):
        if text.count('"') % 2 == 1:
            return True
        if text.count("'") % 2 == 1:
            return True
        return False

    list = [" ", "{", ";", ":", ","]
    for a in list:
        for i in range(len(text)):
            if not is_in_quotes(text[:i]):
                text = text[:i].replace(" " + a, a) + text[i:]
        for i in range(len(text)):
            if not is_in_quotes(text[:i]):
                text = text[:i].replace(a + " ", a) + text[i:]
    return text

def rename_vars(text):
    exclude = ["--font-article"]

    import string
    alphabet = list(string.ascii_letters) # 52 possible variables
    

    list_found = []
    for i in range(len(text)-1):
        if text[i]+text[i+1] == "--":
            end = min(min(text[i:].index(":"), text[i:].index(")")), text[i:].index(" ")) + i
            var_name = text[i:end]
            if var_name not in list_found:
                list_found.append(var_name)

    def check_enough_vars(alphabet, var_giver):
        # if not enough vars in alphabet, add new ones, returns alphabet anyway
        # 52 then 2756 variables after the first var_giver becomes bigger than alphabet
        if var_giver >= len(alphabet):
            l = len(alphabet)
            for i in range(l):
                for j in range(l):
                    new_var = alphabet[i]+alphabet[j]
                    if new_var not in alphabet:
                        alphabet.append(alphabet[i]+alphabet[j])
        return alphabet

    # remove excluded vars
    for var in exclude:
        if var in list_found:
            list_found.remove(var)

    var_giver = 0
    for var in list_found:
        alphabet = check_enough_vars(alphabet, var_giver)
        text = text.replace(var, "--" + alphabet[var_giver])
        var_giver += 1

    return text

# ----------------------------------------------------------

def minifier(text):
    print("\nDémarrage")
    optimisation = 0
    start_len = len(text)
    last_len = start_len

    print("Suppression des tabulations et espaces et des retours à la ligne", end='\t\t')
    text = remove_tabs(text)
    text = remove_star_end_spaces_newlines(text)
    temp = last_len - len(text)
    last_len = len(text)
    print("Espace gagné :", temp)

    print("Suppression des commentaires", end='\t\t')
    text = remove_comments(text)
    temp = last_len - len(text)
    last_len = len(text)
    print("Espace gagné :", temp)

    print("Suppression des espaces inutiles", end='\t\t')
    text = remove_spaces(text)
    temp = last_len - len(text)
    last_len = len(text)
    print("Espace gagné :", temp)
    
    """ EXPERIMENTAL et assez nul faut pas se le cacher
    print("Changement du nom des variables", end='\t\t')
    text = rename_vars(text)
    temp = last_len - len(text)
    last_len = len(text)
    print("Espace gagné :", temp)
    """

    print()
    optimisation = start_len - len(text)
    return (text, optimisation)

# ----------------------------------------------------------
minified, optimisation = minifier(text)
if mode == "read-write":
    print("Écriture du fichier", file_to_write)
    with open(file_to_write, 'w') as file:
        if file:
            file.write(minified)
        else:
            print("Erreur à l'écriture du fichier")

# print(text)
# print(minifier(text))
print("Original :", len(text))
print("Minimisé :", len(minified))
print("\nTERMINÉ")