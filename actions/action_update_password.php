<?php 

session_start();
if ($_SESSION['csrf'] !== $_POST['csrf']) {
    header('Location: ../index.php');
    exit();
  }
require_once('../database/connection.php');
require_once('../database/users.php');
$db = getDatabaseConnection();
$Cpass = $_POST['Cpassword'];
$Npass = $_POST['npassword'];
$CNpass = $_POST['cnpassword'];

$options = ['cost' => 10];
$stmt = $db->prepare("UPDATE Users set password = ? where username = ?");
$stmt->execute(array(password_hash($Npass, PASSWORD_DEFAULT, $options),$_SESSION['username']));

header('Location: ../pages/profile.php'); 
?>