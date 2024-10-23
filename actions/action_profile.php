<?php
session_start();
if ($_SESSION['csrf'] !== $_POST['csrf']) {
    header('Location: ../index.php');
    exit();
  }                                     // starts the session
require_once('../database/connection.php');                 // database connection
require_once('../database/users.php');                      // user table queries
require_once('../database/chats.php');
$db = getDatabaseConnection();
$user = preg_replace("/[^a-zA-Z0-9_]/",'',$_POST['user']);
$action = $_POST['action'];
if($action == "delete"){
    $stmt = $db->prepare("DELETE FROM Users WHERE username = ?");
$stmt->execute(array($user));
header('Location: ../pages/AdminPage.php');   
}
else if($action == "elevate"){
    $stmt = $db->prepare("UPDATE Users SET isAdmin = 1 WHERE username = ?");
$stmt->execute(array($user));
    header('Location: ../pages/profile.php?username='. urlencode($user));
}