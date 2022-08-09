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
    $email = clear($_POST['regEmail'] ?? null);
    $password = clear($_POST['regPassword'] ?? null);
    $login = clear($_POST['regLogin'] ?? null);



    $errors = [];
    if(empty($login)){
        $errors['login'] = 'Login is required';
    }
    if(empty($email)){
        $errors['email'] = 'Email is required';
    }

    if(empty($password)){
        $errors['password'] = 'Password is required';
    }


    if (count($errors) > 0) {
        Message::set($errors, 'danger');
    } else {
        Message::set('Thank!');
    }
    redirect('registration');
}

function sendLogin(){
    $email = clear($_POST['loginEmail'] ?? null);
    $password = clear($_POST['loginPassword'] ?? null);

    $errors = [];
    if(empty($email)){
        $errors['email'] = 'Email is required';
    }

    if(empty($password)){
        $errors['password'] = 'Password is required';
    }

    if (count($errors) > 0) {
        Message::set($errors, 'danger');
    } else {
        Message::set('Thank!');
    }
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
