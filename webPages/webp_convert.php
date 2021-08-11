<?php
function generate_webp_image($file, $compression_quality = 95)
{
    $output = $file . '.webp';
    $result = [];
    // Obtenir l'extension et traiter le fichier en fonction de ça
    $extension = strtolower(pathinfo($file, PATHINFO_EXTENSION));
    if($extension === '.gif') {
        $line = '"scripts/libwebp-1.2.0-windows-x64/bin/gif2webp.exe" -q '.$compression_quality.' '.$file.' -o '.$output;
    } else {
        $line = '"scripts/libwebp-1.2.0-windows-x64/bin/cwebp.exe" -q '.$compression_quality.' '.$file.' -o '.$output;
    }
    exec($line.' 2>&1', $result);
    print_r($result);
    return $result;
}

// Ne fonctionne pas avec les gifs

?>
