<?php

function clear($str)
{
  return htmlentities(trim($str));
}

function dump($arr)
{
  echo '<pre>' . print_r($arr, true) . '</pre>';
}

function redirect($page)
{
  header("Location: index.php?page=$page");
  die();  // exit()
}
function recursiveRemoveDir($dir) {
    $includes = glob($dir . '/*');

    foreach ($includes as $include) {
        if(is_dir($include)) {
            recursiveRemoveDir($include);
        } else {
            unlink($include);
        }
    }
    rmdir($dir);
}

function translit($st)
{
    $st = mb_strtolower($st, "utf-8");
    $st = str_replace([
        '?', '!', '.', ',', ':', ';', '*', '(', ')', '{', '}', '[', ']', '%', '#', '№', '@', '$', '^', '-', '+', '/', '\\', '=', '|', '"', '\'',
        'а', 'б', 'в', 'г', 'д', 'е', 'ё', 'з', 'и', 'й', 'к',
        'л', 'м', 'н', 'о', 'п', 'р', 'с', 'т', 'у', 'ф', 'х',
        'ъ', 'ы', 'э', ' ', 'ж', 'ц', 'ч', 'ш', 'щ', 'ь', 'ю', 'я'
    ], [
        '_', '_', '.', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_',
        'a', 'b', 'v', 'g', 'd', 'e', 'e', 'z', 'i', 'y', 'k',
        'l', 'm', 'n', 'o', 'p', 'r', 's', 't', 'u', 'f', 'h',
        'j', 'i', 'e', '_', 'zh', 'ts', 'ch', 'sh', 'shch',
        '', 'yu', 'ya'
    ], $st);
    $st = preg_replace("/[^a-z0-9_.]/", "", $st);
    $st = trim($st, '_');

    $prev_st = '';
    do {
        $prev_st = $st;
        $st = preg_replace("/_[a-z0-9]_/", "_", $st);
    } while ($st != $prev_st);

    $st = preg_replace("/_{2,}/", "_", $st);
    return $st;
}

function getExtension($filename) {
    $path_info = pathinfo($filename);
    return $path_info['extension'];
}

function watermark($file, $wtermark) {

        if(empty($file) | empty($wtermark)) return false;
        /*
         $wh = getimagesize($watermark);
            $fh = getimagesize($file);

            $rwatermark = imagecreatefrompng($watermark);

            $rfile = imagecreatefromjpeg($file);

            imagecopy($rfile, $rwatermark, $fh[0] - $wh[0], $fh[1] - $wh[1], 0, 0, $wh[0], $wh[1]);

            imagejpeg($rfile, $file, '80');

            imagedestroy($rwatermark);
            imagedestroy($rfile);

            return true;
         */

        if(getExtension($file) == "jpeg" || getExtension($file) == "jpg"){
            $watermark = imagecreatefrompng($wtermark);

            $photo = imagecreatefromjpeg($file);

            $marginSide = 15;
            $marginBottom = 15;

            $photoWidth = imagesx($photo);
            $photoHeight = imagesy($photo);

            $watermarkWidth = imagesx($watermark);
            $watermarkHeight = imagesy($watermark);

            $dstX = ($photoWidth - $watermarkWidth - $marginSide);

            $dstY = ($photoHeight - $watermarkHeight - $marginBottom);


            imagecopy($photo, $watermark, $dstX, $dstY, 0, 0, $watermarkWidth, $watermarkHeight);
            imagejpeg($photo, $file, 100);

            imagedestroy($watermark);
            imagedestroy($photo);

            return true;
        }


        return false;

}

