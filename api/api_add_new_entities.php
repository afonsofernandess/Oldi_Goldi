<?php 
session_start();
require_once('../database/connection.php');
require_once('../database/categories.php');
require_once('../database/chats.php');
$db = getDatabaseConnection();

$category = preg_replace("/[^a-zA-Z0-9]/",'',$_GET['category']);
$brand = preg_replace("/[^a-zA-Z0-9]/",'',$_GET['brand']);
$condition = preg_replace("/[^a-zA-Z0-9]/",'',$_GET['condition']);
$size = preg_replace("/[^a-zA-Z0-9]/",'',$_GET['size']);

if($category != ""){
    $stmt = $db->prepare("INSERT INTO Categories (category_name) VALUES (?)");
    $stmt->execute(array($category));
    echo "<li>" . htmlspecialchars($category) . "</li>";
}

if($brand != ""){
    $stmt = $db->prepare("INSERT INTO Brands (brand_name) VALUES (?)");
    $stmt->execute(array($brand));
    echo "<li>" . htmlspecialchars($brand) . "</li>";
}

if($condition != ""){
    $stmt = $db->prepare("INSERT INTO Conditions (condition_value) VALUES (?)");
    $stmt->execute(array($condition));
    echo "<li>" . htmlspecialchars($condition) . "</li>";
}

if($size != ""){
    $stmt = $db->prepare("INSERT INTO Sizes (size_value) VALUES (?)");
    $stmt->execute(array($size));
    echo "<li>" . htmlspecialchars($size) . "</li>";
}
?>