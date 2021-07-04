import os.path
from webptools import cwebp

in_file = input("enter your file : ")
path = os.path.dirname(in_file) + "\\"
extension = in_file[in_file.index("."):]        
out_file = os.path.basename(in_file)
out_file = out_file[:out_file.index(".")] + ".webp"

print(cwebp(input_image=in_file, output_image=path+out_file, option="-q 60", logging="-v"))
