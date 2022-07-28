<h1>Upload</h1>

<?php Message::get(); ?>
<div class="container overflow-hidden">
    <div class="row gy-5">
        <div class="col-6">
            <form action="index.php" method="POST">
                <input class="form-control" type="text" name="newMkdir" placeholder="name of directory"'>
                <button class="btn btn-primary" name="action" value="uploadMkdir">Add</button>

            </form>
        </div>
        <div class="col-6">
            <form action="index.php" method="POST" enctype="multipart/form-data">
                <select class="form-select" name="directive_name" aria-label="Default select example" >
                    <?php
                    $dir = opendir('./uploads/gallery/');
                    while($file = readdir($dir)) {
                        if (is_dir('./uploads/gallery/'.$file) && $file != '.' && $file != '..') {
                            echo '<option value='.$file.'>'. $file .'</option>';
                        }
                    }
                    ?>
                </select>
                <input type="file" name="uploadedFile">
                <button class="btn btn-primary" name="action" value="uploadImage">Upload</button>
            </form>
        </div>
        <div class="col-6">
            <form action="index.php" method="POST" onSubmit="return confirm('Для видалення всієї інформації нажміть OK');">
                <select class="form-select" name="directive_name" aria-label="Default select example" >
                    <?php
                    $dir = opendir('./uploads/gallery/');
                    while($file = readdir($dir)) {
                        if (is_dir('./uploads/gallery/'.$file) && $file != '.' && $file != '..') {
                            echo '<option value='.$file.'>'. $file .'</option>';
                        }
                    }
                    ?>
                </select>

                <button class="btn btn-primary" name="action" value="deleteDirective">Delete</button>

            </form>

        </div>
    </div>
</div>








