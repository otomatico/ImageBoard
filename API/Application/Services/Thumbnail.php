<?php
function createThumbnail($src, $dest, $width, $height) {
    $type = exif_imagetype($src);
    
    switch ($type) {
        case IMAGETYPE_JPEG:
            $image = imagecreatefromjpeg($src);
            break;
        case IMAGETYPE_PNG:
            $image = imagecreatefrompng($src);
            break;
        case IMAGETYPE_GIF:
            $image = imagecreatefromgif($src);
            break;
        default:
            return false;
    }
    
    $srcWidth = imagesx($image);
    $srcHeight = imagesy($image);
    
    // Calcular relación de aspecto
    $ratio = min($width/$srcWidth, $height/$srcHeight);
    $newWidth = (int)($srcWidth * $ratio);
    $newHeight = (int)($srcHeight * $ratio);
    
    $thumb = imagecreatetruecolor($newWidth, $newHeight);
    
    // Preservar transparencia para PNG/GIF
    if ($type === IMAGETYPE_PNG || $type === IMAGETYPE_GIF) {
        imagecolortransparent($thumb, imagecolorallocatealpha($thumb, 0, 0, 0, 127));
        imagealphablending($thumb, false);
        imagesavealpha($thumb, true);
    }
    
    imagecopyresampled($thumb, $image, 0, 0, 0, 0, $newWidth, $newHeight, $srcWidth, $srcHeight);
    
    // Crear directorio si no existe
    if (!file_exists(dirname($dest))) {
        mkdir(dirname($dest), 0755, true);
    }
    
    switch ($type) {
        case IMAGETYPE_JPEG:
            return imagejpeg($thumb, $dest);
        case IMAGETYPE_PNG:
            return imagepng($thumb, $dest);
        case IMAGETYPE_GIF:
            return imagegif($thumb, $dest);
    }
    
    return false;
}
?>