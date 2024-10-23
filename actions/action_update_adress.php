<?php 
session_start();
if ($_SESSION['csrf'] !== $_POST['csrf']) {
    header('Location: ../index.php');
    exit();
  }
require_once('../database/connection.php');
require_once('../database/categories.php');
require_once('../database/chats.php');
$db = getDatabaseConnection();
$item_id = intval($_POST['item_id']);
$adress = preg_replace("/[^a-zA-Z0-9\s, ]/", '', $_POST['address']);$_POST['address'];
$city = preg_replace("/[^a-zA-Z0-9\s, ]/", '', $_POST['city']);
$country = preg_replace("/[^a-zA-Z0-9\s, ]/", '', $_POST['Country']);
$zip = preg_replace("/[^0-9-]/", '', $_POST['zip']);
$user = getUser($db, $_SESSION['username']);

$stmt = $db->prepare('UPDATE Users SET Adress = ?, Cidade = ?, Country = ?, Zip_code = ? WHERE username = ?');
$stmt->execute(array($adress, $city, $country, $zip, $_SESSION['username']));


header('Location: ../pages/Checkout.php?item_id='. urlencode($item_id));
?>