<?php
  session_start();                                         // starts the session
  if ($_SESSION['csrf'] !== $_POST['csrf']) {
    header('Location: ../index.php');
    exit();
  }
  require_once('../database/connection.php');                 // database connection
  require_once('../database/users.php');                      // user table queries
  require_once('../database/chats.php');
$db = getDatabaseConnection();

$item_id = intval($_POST['item_id']);
$user = preg_replace("/[^a-zA-Z0-9_]/", '', $_POST['user']);

$chat = VerifyChatExists($db,$_SESSION['username'],$user,$item_id);
if($chat == false){
addNewChat($db,$_SESSION['username'],$_POST['user'],$_POST['item_id']);
$chat_id = $db->lastInsertId();

addMessage($db, $chat_id, $_SESSION['username'], $_POST['new_message']);
}
else $chat_id = $chat['chat_id'];
header('Location: ../pages/messages.php?chat_id='. urlencode($chat_id).'');       
?>