<?php require_once './functions/main.php' ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">

    <link rel="stylesheet" type="text/css" href="./slick/slick.css"/>
    <link rel="stylesheet" type="text/css" href="./slick/slick-theme.css"/>
    <link rel="stylesheet" href="css/main.css">
</head>

<body>
  <nav class="navbar navbar-expand-lg bg-light">
    <div class="container-fluid">
      <a class="navbar-brand" href="/project-master">Hw4</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
              <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="/project-master">Home</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="index.php?page=contacts">Contacts</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="index.php?page=upload-image">Upload Image</a>
              </li>
                <li class="nav-item">
                    <a class="nav-link" href="index.php?page=gallery">Gallery</a>
                </li>
        </ul>

        <ul class="navbar-nav ms-auto mb-2 mb-lg-0"> <!--регистрация и логин-->
            <li class="nav-item" >
                <a class="nav-link"  href="index.php?page=login">Login</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="index.php?page=registration">Registration</a>
            </li>
        </ul>


      </div>
    </div>
  </nav>

  <div class="container">

    <?php
    $page = $_GET['page'] ?? 'home';
    if (file_exists("./pages/$page.php")) {
      require_once "./pages/$page.php";
    } else {
      echo '<h1>Page not Found</h1>';
    }

    ?>


  </div>


  <script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
  <script src="./slick/slick.min.js"></script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
  <script src="js/main.js"></script>
</body>

</html>