<?php 
session_start();
if ($_SESSION['csrf'] !== $_POST['csrf']) {
    header('Location: ../index.php');
    exit();
  }
require_once('../database/connection.php');                 // database connection
require_once('../database/users.php');
$username = preg_replace("/[^a-zA-Z0-9_]/",'',$_POST['username']);
$name = preg_replace("/[^a-zA-Z0-9 ]/",'',$_POST['name']);
$email = preg_replace("/[^a-zA-Z0-9@.]/",'',$_POST['email']);

if(newUser($username,$name,$email,$_POST['password'],$_POST['cpassword']) === true){
    header('Location: ../pages/login.php');
    exit;
}


header('Location: ../index.php');        // redirect to the page we came from
?>