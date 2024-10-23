<?php
  session_start();                                         // starts the session
  if ($_SESSION['csrf'] !== $_POST['csrf']) {
    header('Location: ../index.php');
    exit();
  }
  require_once('../database/connection.php');                 // database connection
  require_once('../database/users.php');                      // user table queries
  $username = preg_replace("/[^a-zA-Z0-9]/",'',$_POST['username']);

  if (userExists($username, $_POST['password'])) { // test if user exists
    $_SESSION['username'] = $username;
    $_SESSION['order'] = '0';         // store the username
    header('Location: ../index.php');
  }
  else{
    header("Location: ../index.php");
  }        // redirect to the page we came from
?>