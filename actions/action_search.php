<?php
session_start();
require_once('../database/connection.php');
require_once('../database/categories.php');
$db = getDatabaseConnection();
$input = preg_replace("/[^a-zA-Z0-9]/",'',$_GET['inputbar']);
$category = $_GET['Categories'];

$cat_id = getCategorieByName($db,$category);


if($input != ""){
    $encodedInput = urlencode($input);
    if($category != 'All') header('Location: ../pages/items.php?input=' . $encodedInput . '&' . 'category_id=' . urlencode($cat_id));
    else header('Location: ../pages/items.php?input=' . $encodedInput);
}
else header('Location: ../index.php');


?>