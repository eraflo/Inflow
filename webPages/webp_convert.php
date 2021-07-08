<?php

/**
 * Generate Webp image format
 * 
 * Uses either Imagick or imagewebp to generate webp image
 * 
 * @param string $file Path to image being converted.
 * @param int $compression_quality Quality ranges from 0 (worst quality, smaller file) to 100 (best quality, biggest file).
 * 
 * @return false|string Returns path to generated webp image, otherwise returns false.
 * 
 * https://www.jclabs.co.uk/generate-webp-images-in-php-using-and-gd-or-imagick/
 */
function generate_webp_image($file, $compression_quality = 80)
{
    // check if file exists
    if (!file_exists($file)) {
        return false;
    }

    // If output file already exists return path
    $output_file = $file . '.webp';
    if (file_exists($output_file)) {
        return $output_file;
    }

    $file_type = strtolower(pathinfo($file, PATHINFO_EXTENSION));

    if (function_exists('imagewebp')) {
        switch ($file_type) {
            case 'jpeg':
            case 'jpg':
                $image = imagecreatefromjpeg($file);
                break;

            case 'png':
                $image = imagecreatefrompng($file);
                imagepalettetotruecolor($image);
                imagealphablending($image, true);
                imagesavealpha($image, true);
                break;

            case 'gif':
                $image = imagecreatefromgif($file);
                break;
            default:
                return false;
        }

        // Save the image
        $result = imagewebp($image, $output_file, $compression_quality);
        if (false === $result) {
            return false;
        }

        // Free up memory
        imagedestroy($image);

        return $output_file;
    } elseif (class_exists('Imagick')) {
        $image = new Imagick();
        $image->readImage($file);

        if ($file_type === 'png') {
            $image->setImageFormat('webp');
            $image->setImageCompressionQuality($compression_quality);
            $image->setOption('webp:lossless', 'true');
        }

        $image->writeImage($output_file);
        return $output_file;
    }

    return false;
} ?>