<?php 
session_start();
require_once('../database/connection.php');
require_once('../database/categories.php');
$db = getDatabaseConnection();
$order = $_GET['order'];

$_SESSION['order'] = $order;


if($order == '0'){
    $items = getAllItems($db);
}
else {
    $items = getItemsByOrder($db, $order);
}

echo display_items($db, $items);