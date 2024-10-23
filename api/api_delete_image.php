<?php 
require_once('../database/connection.php');
require_once('../database/categories.php');
session_start();
$db = getDatabaseConnection();
$photo_id = intval($_GET['photo_id']);
$item_id = intval($_GET['item_id']);

$stmt = $db->prepare("SELECT photo_url FROM Photos WHERE photo_id = ?");
$stmt->execute(array($photo_id));
$photo = $stmt->fetch();

if ($photo && file_exists($photo['photo_url'])) {
    unlink($photo['photo_url']);
}

$stmt = $db->prepare("DELETE FROM Photos WHERE photo_id = ?");
$stmt->execute(array($photo_id));


echo "ok";
?>