<?php 
session_start();
require_once('../database/connection.php');
require_once('../database/categories.php');
require_once('../database/chats.php');
$db = getDatabaseConnection();

$card_id = intval($_GET['card_id']);
$cardNumber = preg_replace("/[^0-9]/",'',$_GET['cardNumber']);
$cardName = preg_replace("/[^a-zA-Z0-9]/",'',$_GET['cardName']);
$cardExpDate = $_GET['expDate'];
$cardCVV = preg_replace("/[^0-9]/",'',$_GET['cvv']);
if($card_id > 0){
    $stmt = $db->prepare('DELETE FROM Cards WHERE card_id = ?');
    $stmt->execute(array($card_id));
    echo "Carddeleted";
}
else{
addNewCard($db,$cardNumber, $cardName, $cardExpDate, $cardCVV);

echo addCard($db,$cardNumber, $cardName, $cardExpDate, $cardCVV);
}


?>