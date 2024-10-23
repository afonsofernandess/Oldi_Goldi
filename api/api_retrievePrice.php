<?php 

session_start();
require_once('../database/connection.php');
require_once('../database/categories.php');
require_once('../database/chats.php');
$db = getDatabaseConnection();

$chat_id = intval($_GET['chat_id']);


$chat = getChat($db,$chat_id);

$item_new_price = getNewPrice($db,$chat['buyer'],$chat['item_id']);


$item = getItem($db,$chat['item_id']);

if(isset($item_new_price)){
    echo $item_new_price ."€";
} else {
    echo $item['price']. "€";
}



