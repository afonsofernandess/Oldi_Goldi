<?php 
require_once('../database/connection.php');
require_once('../database/categories.php');
session_start();
if ($_SESSION['csrf'] !== $_POST['csrf']) {
    header('Location: ../index.php');
    exit();
  }
$db = getDatabaseConnection();
$name = preg_replace("/[^a-zA-Z0-9 ]/",'',$_POST['item_name']);
$description = isset($_POST['item_description']) ? preg_replace("/[^a-zA-Z0-9 ]/",'',$_POST['item_description']) : null;
$size = $_POST['Sell_Size'];
$condition = $_POST['Sell_Conditions'];
$brand = $_POST['Sell_Brand'];
$price = $_POST['item_price'];
$category =  $_POST['Sell_Categories'];
$item_id = isset($_POST['item_id']) ? intval($_POST['item_id']) : null;


$imageDir = '../images/';

$imagePaths = [];


foreach ($_FILES['item_images']['tmp_name'] as $key => $tmp_name) {
    $imageName = uniqid() . '-' . $_FILES['item_images']['name'][$key];

    $imagePath = $imageDir . $imageName;

    if (move_uploaded_file($tmp_name, $imagePath)) {
        $imagePaths[] = $imagePath;
    }
}



if($item_id != null){
    if($size != 'Nosize')$size_id = getSizeByName($db,$size);
    else $size_id = null;
    if($brand != "Other")$brand = getBrandByName($db,$brand);
    $condition_id = getConditionByName($db,$condition);
    $category_id = getCategorieByName($db,$category);
    $stmt = $db->prepare("UPDATE Item SET item_name = ?, description = ?, price = ?, size_id = ?, condition_id = ?, category_id = ?, brand_id = ? WHERE ItemID = ?");
    $stmt->execute(array($name,$description,$price,$size_id,$condition_id,$category_id,$brand,$item_id));
    
    foreach ($imagePaths as $path) {
        $stmt = $db->prepare("INSERT INTO Photos (photo_url, item_id) VALUES (?, ?)");
        $stmt->execute([$path, $item_id]);
    }
    
} else {

if($size != 'Nosize'){
    $size_id = getSizeByName($db,$size);  

}
else $size_id = null;


if($brand != "Other"){
    $brand_id = getBrandByName($db,$brand);
}

$current_id = getCurrentItem_id($db) + 1;

foreach ($imagePaths as $path) {
    $stmt = $db->prepare("INSERT INTO Photos (photo_url, item_id) VALUES (?, ?)");
    $stmt->execute([$path, $current_id]);
}

$condition_id = getConditionByName($db,$condition);
$category_id = getCategorieByName($db,$category);
$stmt = $db->prepare("INSERT INTO Item (ItemID, model, item_name, description, price, seller, size_id, condition_id, category_id, brand_id) VALUES (?,?,?,?,?,?,?,?,?,?)");
$stmt->execute(array($current_id,"FFFFF",$name,$description,$price,$_SESSION['username'],$size_id,$condition_id,$category_id,$brand_id));
}
header('Location: ../pages/profile.php');

?>