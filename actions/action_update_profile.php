<?php
session_start();
if ($_SESSION['csrf'] !== $_POST['csrf']) {
    header('Location: ../index.php');
    exit();
  }
require_once('../database/connection.php');               
require_once('../database/users.php'); 

$db = getDatabaseConnection();

$description = preg_replace("/[^a-zA-Z0-9 ]/",'',$_POST['description']);
$email = preg_replace("/[^a-zA-Z0-9@.]/",'',$_POST['email']);
$name = preg_replace("/[^a-zA-Z0-9 ]/",'',$_POST['name']);
$phoneNumber = preg_replace("/[^0-9+]/",'',$_POST['pn']);
$address = preg_replace("/[^a-zA-Z0-9 ,]/",'',$_POST['address']);
$zipCode = preg_replace("/[^0-9-]/",'',$_POST['ZP']);
$country = preg_replace("/[^a-zA-Z0-9 ]/",'',$_POST['Country']);
$city = preg_replace("/[^a-zA-Z0-9 ]/",'',$_POST['City']);
$photo_url = $_POST['imgSrc'];

if($country == "") $country = null;
if($city == "") $city = null;   
if ($photo_url === "") {
    $query = "UPDATE Users SET description = ?, email = ?, name = ?, phone_number = ?, Adress = ?, Zip_code = ?, Country = ?, Cidade = ? WHERE username = ?";
    $stmt = $db->prepare($query);
    $stmt->execute(array($description,$email,$name,$phoneNumber,$address,$zipCode,$country,$city, $_SESSION['username']));
} else {
    $query = "UPDATE Users SET description = ?, email = ?, name = ?, phone_number = ?, Adress = ?, Zip_code = ?, Country = ?, Cidade = ?, photo_url = ? WHERE username = ?";
    $stmt = $db->prepare($query);
    $stmt->execute(array($description,$email,$name,$phoneNumber,$address,$zipCode,$country,$city,$photo_url,$_SESSION['username']));
}

header('Location: ../pages/profile.php'); 
?>