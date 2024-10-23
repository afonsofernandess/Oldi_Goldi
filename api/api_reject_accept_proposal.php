<?php 
session_start();
require_once('../database/connection.php');
require_once('../database/users.php');
require_once('../database/chats.php');
$db = getDatabaseConnection();

$messageId = intval($_GET['message_id']);
$action = $_GET['action'];

$message = getMessage($db,$messageId);
$chat_id = $message['chat_id'];
$chat = getChat($db,$chat_id);


if($action == "reject"){
    

    $newMessage = $message['message'] . ' - REJECTED!';

    $stmt = $db->prepare("UPDATE messages SET message = ? WHERE message_id = ?");
    $stmt->execute([$newMessage, $messageId]);
    $messages = getLimitedMessages($db,$chat_id);
    echo displayMessages($messages,$db,$chat);

}
else if($action == "accept"){
    

    $newMessage = $message['message'] . ' - ACCEPTED!';

    // Update the message in the database
    $stmt = $db->prepare("UPDATE messages SET message = ? WHERE message_id = ?");
    $stmt->execute([$newMessage, $messageId]);


    $item = getChatItem($db,$chat_id);


    $stmt = $db->prepare("INSERT INTO UserPrices (username, ItemID, proposed_price) VALUES (?, ?, ?)");
    $stmt->execute(array($message['sender_id'], $item['item_id'], $message['price_proposal']));

    header('Location: ../pages/messages.php?chat_id='. urlencode($chat_id) .'');
}


