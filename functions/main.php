<?php
require_once './functions/Message.php';
require_once './functions/helpers.php';
require_once './functions/ImageResize.php';
session_start();

$action = $_POST['action'] ?? null;
if (!empty($action) && function_exists($action)) {
  $action();
}

function sendReg(){
    $regLogin = clear($_POST['regLogin'] ?? '');
    $regEmail = clear($_POST['regEmail'] ?? '');
    $regPassword = clear($_POST['regPassword'] ?? '');
    $path = 'Database/users.txt';


    if (!$regLogin || !$regEmail || !$regPassword) {
        Message::set('All fields are required', 'danger');
        redirect('registration');
    }


    $users = [];
    if (file_exists($path)) {
        $users = json_decode(file_get_contents($path));
    }

    $f = fopen($path, 'w');

    $toAdd = true;
    foreach ($users as $user) {
        if($user[0] == $regLogin) {
            Message::set('another user has the same login', 'danger');
            $toAdd = false;
            break;
        }else if($user[1] == $regEmail){
            Message::set('another user has the same email', 'danger');
            $toAdd = false;
            break;
        }
    }

    if($toAdd){
        $users[] = [$regLogin, $regEmail, md5($regPassword)];
        Message::set('Thank');
        $_SESSION['user'] = $regLogin;
    }

    fwrite($f, json_encode($users));
    fclose($f);



    redirect('home');
}

function leave(){
    unset($_SESSION['user']);
    redirect('home');
}

function sendLogin(){
    $EmailOrLogin = clear($_POST['loginEmail'] ?? '');
    $password = clear($_POST['loginPassword'] ?? '');
    $path = 'Database/users.txt';


    if (!$EmailOrLogin || !$password) {
        Message::set('All fields are required', 'danger');
        redirect('login');
    }


    $users = [];
    if (file_exists($path)) {
        $users = json_decode(file_get_contents($path));
    }

    $f = fopen($path, 'r');

    $registrated = false;
    foreach ($users as $user) {
        if($user[0] == $EmailOrLogin || $user[1] == $EmailOrLogin) {
            $registrated = true;
            if ($user[2] === md5($password)) {
                $_SESSION['user'] = $EmailOrLogin;
                redirect('home');

            } else {
                Message::set('wrong pass', 'danger');
            }
            break;
        }
    }

    if(!$registrated){
        Message::set('user not found','danger');
    }
    fclose($f);

    redirect('login');
}
function sendMail()
{
  $email = clear($_POST['email'] ?? null);
  $subject = clear($_POST['subject'] ?? null);
  $message = clear($_POST['message'] ?? null);

  $errors = [];
  if (empty($email)) {
    $errors['email'] = 'Email is required';
  }
  if (empty($subject)) {
    $errors['subject'] = 'Subject is required';
  }
  if (empty($message)) {
    $errors['message'] = 'Message is required';
  }

  if (count($errors) > 0) {
    Message::set($errors, 'danger');
  } else {
    Message::set('Thank!');
  }

  redirect('contacts');
}
function deleteDirective(){

    $dir = $_POST['directive_name'] ?? null;
    recursiveRemoveDir('./uploads/gallery/'.$dir);
    Message::set('directive is deleted');
    redirect('upload-image');


}
function uploadMkdir(){
    $folderUploads = 'uploads/';
    $folderGallery = 'uploads/gallery/';
    $error = 0;

    if(!file_exists($folderUploads)){
        mkdir('uploads');
    }
    if(!file_exists($folderGallery)){
        mkdir('uploads/gallery');
    }

    $mkdirName = $_POST['newMkdir'] ?? null;
    $mkdirName = str_replace(" ", "-", $mkdirName);//что б не было пробелов при создании

    if(!file_exists('./uploads/gallery/'.$mkdirName)){
        mkdir('./uploads/gallery/'.$mkdirName);
        mkdir('./uploads/gallery/'.$mkdirName.'/small_img');
    }


    if($error != 0){
        Message::set('Error','danger');
        redirect('upload-image');
    }
    Message::set('directory is upload');
    redirect('upload-image');
}

function uploadImage(){
    $dir = $_POST['directive_name'] ?? null;
    $file = $_FILES['uploadedFile'] ?? null;
    extract($file);

    if($error != 0){
        Message::set('Error','danger');
        redirect('upload-image');
    }

    $allowedFiles = ['image/jpeg','image/png','image/webp'];
    if(!in_array($type,$allowedFiles)){
        Message::set('File is not image','danger');
        redirect('upload-image');
    }

    $name = translit($name);

    $folderUploads = 'uploads/';
    $folderGallery = 'uploads/gallery/';

    if(!file_exists($folderUploads)){
        mkdir('uploads');
    }
    if(!file_exists($folderGallery)){
        mkdir('uploads/gallery');
    }


    if(!move_uploaded_file($tmp_name,'./'.$folderGallery.'/'.$dir.'/'.$name)){
        Message::set('Error','danger');
        redirect('upload-image');
    }



    $img = new ImageResize('./'.$folderGallery.'/'.$dir.'/'. $name);
    $img->resize(300,300);
    $img->save();

    $newfile = './'.$folderGallery.'/'.$dir.'/'. $name;


    $watermark = 'watermark/watermark.png';

    watermark($newfile, $watermark);


    Message::set('File is upload');
    redirect('upload-image');
}
