<?php
    header('Content-type: image/png');
    $dest = imagecreatetruecolor(150,150);
    $src = imagecreatefrompng('../uploads/test.png');

    $src_width = imagesx($src);
    $src_height = imagesy($src);

    imagecopyresampled($dest, $src, 0, 0, $src_width / 2 - $src_height / 2, 0, 150, 150, $src_height, $src_height);

    imagepng($dest);