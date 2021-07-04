import os.path as path
import sys
from webptools import cwebp

def converter(in_file, out_file):
    file_path = path.dirname(in_file) + "\\"
    extension = in_file[in_file.index("."):]
    if out_file == None :
        out_file = path.basename(in_file)
        out_file = out_file[:out_file.index(".")] + ".webp"
    print(cwebp(input_image = in_file, output_image = file_path + out_file, option = "-q 60", logging = "-v"))

args = sys.argv

if len(args) != 3 :
    print("wrong arguments : webp_converter [in_file] [out_file] \n\t [obliged] (optional)")
else:
    converter(args[1], args[2])
