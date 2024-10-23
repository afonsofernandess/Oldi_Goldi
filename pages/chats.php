<?php 

require_once('../templates/common.php');
require_once('../templates/display_categories.php');


$db = getDatabaseConnection();
$categories = getAllCategories($db);
$brands = getAllBrands($db);
output_header($db);
display_categories($categories);

$chats = getAllChats($db,$_SESSION['username']);



?>

<section id="chats_page">
    <aside id="chats">
        <h2>Chats</h2>
        <?php if(count($chats) == 0){ ?>
            <p>You have no chats</p>
        <?php } ?>
        <ul id="chats">
        <?php foreach($chats as $chat){
            $item3 = getItem($db,$chat['item_id']);
            if(!$item3){
                $item3 = getSoldItem($db,$chat['item_id']);
            }
            $message = getLastMessage($db,$chat['chat_id']);
            if($chat['seller'] != $_SESSION['username']){
                $user = getUser($db,$chat['seller']);
            }
            else{
                $user = getUser($db,$chat['buyer']);
            }?>
            <li data-chat-id="<?= htmlspecialchars($chat['chat_id']) ?>" class="chat_item">
                <img src="<?= htmlspecialchars($user['photo_url']) ?>" alt="profile_picture" class="profile_picture">
                <section class="chat_info">
                    <section class="chat_names_info">
                        <span id="name"><?= htmlspecialchars($user['name']) ?></span>
                        <span id="item_name">Item: <?= htmlspecialchars($item3['item_name']) ?></span>
                    </section>
                    <section class="chat_latest_message">
                        <span id="latest_message"><?= htmlspecialchars($message['message']) ?></span>
                        <span id="time_last_message"><?= htmlspecialchars($message['timestamp']) ?></span>
                    </section>
                </section>
                <a href="messages.php?chat_id=<?= urlencode($chat['chat_id']) ?>" class="chat_arrow">
                <i class="fa-solid fa-arrow-right"></i>
                </a>
            </li>
        <?php } ?>
        </ul>
    </aside>
</section>

