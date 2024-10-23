<?php 

require_once('../templates/common.php');
require_once('../templates/display_categories.php');


$db = getDatabaseConnection();
$categories = getAllCategories($db);
$brands = getAllBrands($db);
output_header($db);
display_categories($categories);

$chat_id = urldecode($_GET['chat_id']);
$chat = getChat($db,$chat_id);
$item = getItem($db,$chat['item_id']);

if(!$item){
    $item = getSoldItem($db,$chat['item_id']);
}
$photos = getPhotos($db,$item['ItemID']);
$brand = getBrand($db, $item['brand_id']);
$size = getSize($db, $item['size_id']);
$condition = getCondition($db, $item['condition_id']);
$chat = getChat($db,$chat_id);
$item_new_price = getNewPrice($db,$chat['buyer'],$item['ItemID']);

?>

<input type="hidden" id="message_id"  value="<?= htmlspecialchars($chat_id) ?>">

<section id="message_area">
    <section id = "messages_header">
        <a href="chats.php" class="back_arrow"><i class="fas fa-arrow-left"></i></a>
        <h2>Messages</h2>
    </section>
    <section id="chat_area" class = "chat_area">
        <section id="item_info">
            <a href="item.php?item_id=<?= urlencode($item['ItemID']) ?>"><img src="<?= htmlspecialchars($photos[0]['photo_url']) ?>" width="100" height="100" alt="item_photo"></a>
            
            <section id = "message_item_details">
                <section id = "message_item_top">
                    <span id="item_name"><?= htmlspecialchars($item['item_name']) ?></span>

                    <?php if(isset($item_new_price)){ ?>
                    <span id="item_price"><?= htmlspecialchars($item_new_price) ?>€</span>
                    <?php } else { ?>
                    <span id="item_price"><?= htmlspecialchars($item['price']) ?>€</span>
                    <?php } ?>
                </section>
                
                <section id = "message_item_bottom">
                    <?php if(isset($condition['condition_value'])){ ?>
                    <span id="item_condition"><?= htmlspecialchars($condition['condition_value']) ?></span> 
                    <?php } ?>

                    <?php if(isset($size['size_value'])){ ?>
                    <span id="item_size"><?= htmlspecialchars($size['size_value']) ?></span> 
                    <?php } ?>
                    
                    <?php if(isset($brand['brand_name'])){ ?>
                    <span id="item_brand"><?= htmlspecialchars($brand['brand_name']) ?></span> 
                    <?php } ?>
                </section>
            </section>

            <section id = "message_price_buttons">
                <?php if($item['seller'] != $_SESSION['username']){ 
                    if($item['is_sold'] == 0){ ?>
                <button id="PNPBtn">Propose New Price</button>
                <a id = "message_buy_item" href="Checkout.php?item_id=<?= urlencode($chat['item_id']) ?>">BUY NOW</a>
                <?php } else { ?>
                <span id="item_sold"><b>- SOLD!</b></span>
                <?php } ?>
                <?php } ?>
            </section>
        </section>

        <section id = "messages_about_item">
            <ul id="Message_list">
            <?php $messages = getLimitedMessages($db,$chat['chat_id']);

            foreach($messages as $message){
            $sender = getUser($db,$message['sender_id']);
            $position = ($_SESSION['username'] === $sender['username']) ? 'sender' : 'receiver';
            
            if ($message['is_price_proposal'] && $_SESSION['username'] == $chat['seller'] && strpos($message['message'], 'REJECT') === false && strpos($message['message'], 'ACCEPT') === false) {
                   ?>
                    <li class="<?= $position ?>">
                            Old Price: <?= htmlspecialchars($item['price']) ?>€ <br> <?= htmlspecialchars($message['message']) ?>
                    </li>
                    
                    <form action="../api/api_reject_accept_proposal.php" method="get">
                        <input type="hidden" name="action" value="accept">
                        <input type="hidden" name="message_id" value="<?= htmlspecialchars($message['message_id']) ?>">
                        <button id="Accept_Btn">Accept</button>
                    </form>
                    <button id="Reject_Btn" data-message-id="<?= htmlspecialchars($message['message_id']) ?>">Reject</button>
                <?php } else if ($message['is_price_proposal']) {
                   ?>
                    <li class="<?= $position ?>">
                            Old Price: <?= htmlspecialchars($item['price']) ?>€ <br> <?= htmlspecialchars($message['message']) ?>
                    </li>
                   
                <?php } else { ?>
                    <li class="<?= $position ?>"><?= htmlspecialchars($message['message']) ?></li>
                <?php } ?>
            <?php } ?>
            </ul>

            <form id = "send_message_box" action="">
                <input type="text" name="message" id="message_box">
                <input type="hidden" name="chat_id" id="hidden_chat_id" value="<?= $chat_id?>">
                <button type="submit" id="sendMessage"><i class="fa-solid fa-arrow-right"></i></button>
            </form>
        </section>
    </section>

</section>

<section id="newPrice_PopUp">
<section id="NP_PopUpContent">
<span id="close" class="close">&times;</span>
<h2>Propose New Price</h2>
<form action="../actions/action_send_new_price.php" method="post">
<label>New Price:<input type="number" id="new_price" name="new_price"></label>
<input type="hidden" name="chat_id" value="<?= $chat_id?>">
<input type="hidden" name="csrf" value="<?= $_SESSION['csrf'] ?>">
<button type="submit" >Make Proposal</button>
</form>
</section>
</section>

