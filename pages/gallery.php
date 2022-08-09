<h1>Gallery</h1>

<?php Message::get(); ?>

<form action="index.php" method="POST">
    <?php
        $dir = opendir('./uploads/gallery/');
        while($file = readdir($dir)) {
            if (is_dir('./uploads/gallery/'.$file) && $file != '.' && $file != '..') {
                $folder = "./uploads/gallery/".$file."/small_img";
                echo '<h1 align="center">'.$file.'</h1>';
                $formats = array(
                    "/*.jpg",
                    "/*.png",
                    "/*.jpeg",
                    "/*.webp"
                );

                echo '<div class="slider multiple-items">';
                    foreach($formats as $format){
                        $img_arr = glob($folder . $format);
                        foreach($img_arr as $img)
                        {
                            $str = $img;
                            $path_to_big_pict = str_replace('small_img/300x300-','',$str);
                            echo "<div><a href='$path_to_big_pict' data-lightbox='$folder'><img src='$img'></a></div>";

                        }
                    }
                echo '</div>';
            }
        }
    ?>



</form>