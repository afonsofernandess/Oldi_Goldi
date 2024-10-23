<?php 

session_start();
require_once('../database/connection.php');
require_once('../database/users.php');
$db = getDatabaseConnection();

$username = preg_replace("/[^a-zA-Z0-9]/",'',$_POST['username']);
$password = $_POST['password'];


if(!verify_UsernameExists($db,$username)){
    echo "erro1";
}
else if(!verify_IfPasswordMatch($db,$username,$password)){
    echo "erro2";
}

else echo "true";




?>