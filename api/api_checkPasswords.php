<?php 

session_start();
if ($_SESSION['csrf'] !== $_POST['csrf']) {
    header('Location: ../index.php');
    exit();
}
require_once('../database/connection.php');
require_once('../database/users.php');
$db = getDatabaseConnection();

$CP = $_POST['Cpassword'];
$NP = $_POST['npassword'];
$CNP = $_POST['cnpassword'];

if(verify_UserPassword($db,$_SESSION['username'],$CP)){
    
    if($NP == $CNP){
        echo "true";
    }
    else echo "erro2";

}
else{
    echo "erro1";
}




?>