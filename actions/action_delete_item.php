<?php 

session_start();
if ($_SESSION['csrf'] !== $_POST['csrf']) {
    header('Location: ../index.php');
    exit();
}
require_once('../database/connection.php');
require_once('../database/categories.php');


$db = getDatabaseConnection();
$item_id = intval($_POST['item_id']);
if($item_id == 0){
    header('Location: ../index.php');
    exit();
}
$stmt = $db->prepare("DELETE FROM Item WHERE ItemID = ?");
$stmt->execute(array($item_id));

$stmt = $db->prepare("SELECT photo_url FROM Photos WHERE item_id = ?");
$stmt->execute(array($item_id));
$photos = $stmt->fetchAll();

foreach($photos as $photo){
    if ($photo && file_exists($photo['photo_url'])) {
        unlink($photo['photo_url']);
    }
}


$stmt = $db->prepare("DELETE FROM Photos WHERE item_id = ?");
$stmt->execute(array($item_id));
header('Location: ../pages/profile.php');

?>

