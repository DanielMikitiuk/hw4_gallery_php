<h1>Gallery</h1>

<?php Message::get(); ?>

<form action="index.php" method="POST">
<!--    <div class="slider multiple-items">-->
    <?php
        $dir = opendir('./uploads/gallery/');
        while($file = readdir($dir)) {
            if (is_dir('./uploads/gallery/'.$file) && $file != '.' && $file != '..') {
                $folder = "./uploads/gallery/".$file;
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
                            echo "<div><img src='$img'></div>";
                        }
                    }
                echo '</div>';
            }
        }
    ?>
<!--    </div>-->



</form>