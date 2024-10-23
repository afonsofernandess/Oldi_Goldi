<?php 
session_start();
require_once('../database/connection.php');
require_once('../database/is_on_whishlist.php');
$db = getDatabaseConnection();
$itemID = intval($_GET['item_id']);
$username = preg_replace("/[^a-zA-Z0-9]/",'',$_SESSION['username']);
toggleWhishlist($db, $itemID, $username);
echo isOnwhishlist($db,$itemID,$username) ? 'fa-solid fa-heart' : 'fa-regular fa-heart';

?>