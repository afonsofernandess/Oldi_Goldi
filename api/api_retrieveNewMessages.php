<?php 

session_start();
require_once('../database/connection.php');
require_once('../database/categories.php');
require_once('../database/chats.php');
$db = getDatabaseConnection();

$chat_id = intval($_GET['chat_id']);
$messageId = getLastID($db);



$chat = getChat($db,$chat_id);

$item = getItem($db,$chat['item_id']);

$item_new_price = getNewPrice($db,$chat['buyer'],$chat['item_id']);

$message = getLastMessageID($db,$chat_id,$messageId);


$messages = getLimitedMessages($db,$chat['chat_id']);

    $sender = getUser($db, $message['sender_id']);
    $position = ($_SESSION['username'] === $sender['username']) ? 'sender' : 'receiver';

         

        foreach($messages as $message){
            $sender = getUser($db,$message['sender_id']);
            $position = ($_SESSION['username'] === $sender['username']) ? 'sender' : 'receiver';
            
            if ($message['is_price_proposal'] && $_SESSION['username'] == $chat['seller'] && strpos($message['message'], 'REJECT') === false && strpos($message['message'], 'ACCEPT') === false) {
                echo "<li class='".$position."'>Old Price: ".htmlspecialchars($item['price'])."€ <br>".htmlspecialchars($message['message'])."</li>";
                
                echo "<form action='../api/api_reject_accept_proposal.php' method='get'>
                        <input type='hidden' name='action' value='accept'>
                        <input type='hidden' name='message_id' value='".htmlspecialchars($message['message_id'])."'>
                        <button id='Accept_Btn'>Accept</button>
                      </form>
                      <button id='Reject_Btn' data-message-id='".htmlspecialchars($message['message_id'])."'>Reject</button>";
            } else if ($message['is_price_proposal']) {
                    echo "<li class='".$position."'>Old Price: ".htmlspecialchars($item['price'])."€ <br>".htmlspecialchars($message['message'])."</li>";
                
            } else {
                echo "<li class='".$position."'>".htmlspecialchars($message['message'])."</li>";
            }
        }

    



