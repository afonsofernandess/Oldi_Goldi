<?php 



require_once('../templates/common.php');
require_once('../templates/display_categories.php');

$db = getDatabaseConnection();
$categories = getAllCategories($db);
output_header($db);
display_categories($categories);
$user = getUser($db, $_SESSION['username']);
$item_id = urldecode($_GET['item_id']);
$item = getItem($db, $item_id);
$photos = getPhotos($db,$item['ItemID']);
$brand = getBrand($db, $item['brand_id']);
$size = getSize($db, $item['size_id']);
$condition = getCondition($db, $item['condition_id']);
$item_new_price = getNewPrice($db,$_SESSION['username'],$item['ItemID']);
?>
<main>
    <section id="checkout_page">
        <h2>Checkout</h2>
        <section id="Item_Info">
            <h2>Item</h2>
            <section id="item_details">
            <a href="item.php?item_id=<?= urlencode($item['ItemID']) ?>"><img src="<?= htmlspecialchars($photos[0]['photo_url']) ?>" width="100" height="100" alt="item_photo"></a>
            
            <section id = "checkout_item_details">
                <section id = "checkout_item_top">
                    <span id="item_name"><?= htmlspecialchars($item['item_name']) ?></span>

                    <?php if(isset($item_new_price)){ ?>
                    <span id="item_price"><?= htmlspecialchars($item_new_price) ?>€</span>
                    <?php } else { ?>
                    <span id="item_price"><?= htmlspecialchars($item['price']) ?>€</span>
                    <?php } ?>
                </section>
                
                <section id = "checkout_item_bottom">
                    <?php if(isset($condition)) { ?>
                    <span id="item_condition"><?= htmlspecialchars($condition['condition_value']) ?></span> 
                    <?php } ?>

                    <?php if(isset($size)) { ?> 
                    <span id="item_size"><?= htmlspecialchars($size['size_value']) ?></span> 
                    <?php } ?>
                    
                    <?php if(isset($brand)) { ?>
                    <span id="item_brand"><?= htmlspecialchars($brand['brand_name']) ?></span> 
                    <?php } ?>
                </section>
            </section>
        </section>
        
        

        <section id="shipping_info">
            <?php if($user['Country'] != "" && $user['Cidade'] != "" && $user['Adress'] != "" && $user['Zip_code'] != ""){ ?>
                <h3>Shipping Address</h3>
                <span id="Full name"><?= htmlspecialchars($user['name']) ?></span><br>
                <span class="address"><i class="fa fa-home" aria-hidden="true"></i> <?= htmlspecialchars( $user['Adress'])?>, <?= htmlspecialchars( $user['Cidade']) ?>, <?= htmlspecialchars($user['Country']) ?></span>
                <span class="zip_code"><?= htmlspecialchars($user['Zip_code'])?></span>
                <button id="CABtn">Change Address</button>
            <?php }else { ?>
            <form action="../actions/action_update_adress.php" method="post">
                <h2>Complete your Shipping Address</h2>
                <label for="address">Address:</label><br>
                <input type="text" id="address" name="address" value="<?= isset($user['Adress']) ? htmlspecialchars($user['Adress']) : '' ?>"  required><br>
                <label for="city">City:</label><br>
                <input type="text" id="city" name="city" value="<?= isset($user['Cidade']) ? htmlspecialchars($user['Cidade']) : '' ?>" required><br>
                <label for="Country">Country:</label><br>
                <input type="text" id="Country" name="Country" value="<?= isset($user['Country']) ? htmlspecialchars($user['Country']) : '' ?>" required><br>
                <label for="zip">Zip Code:</label><br>
                <input type="text" id="zip" name="zip" value="<?= isset($user['Zip_code']) ? htmlspecialchars($user['Zip_code']) : '' ?>" required><br>
                <input type="hidden" name="item_id" value="<?= htmlspecialchars($item_id) ?>">
                <input type="hidden" name="csrf" value="<?= $_SESSION['csrf'] ?>">
            <button >Confirm Shipping Info</button>
            </form>
            <?php } ?>
        </section>

    </section>

 

<form action="../actions/action_checkout.php" method="post">
<section id="Payment_Method">
        <h3>Payment Method</h3>
        <input type="radio" id="credit" name="payment" value="credit" required>
        <label for="credit">Credit card</label><br>
        </section>
<section id="creditCardInfo">
    <section id="myCards">
        <h2>My Cards</h2>
        <?php $cards = getCards($db, $_SESSION['username']); 
        if($cards){?>
        <section id="cards">
        <?php foreach($cards as $card){ ?>
    <label ><input type="radio" id="input_<?=htmlspecialchars($card['card_id']) ?>" name="card" value="<?= htmlspecialchars($card['card_id']) ?>" required>
        <?php if($card['card_number'][0] == '2' || $card['card_number'][0] == '5'){ ?>
            <span>Mastercard</span><br>
        <?php } else if($card['card_number'][0] == '4'){ ?>
            <span>Visa</span><br>
        <?php } else if($card['card_number'][0] == '3'){ ?>
            <span>American Express</span>
        <?php } ?>
        <span>**** **** **** <?= htmlspecialchars(substr($card['card_number'], -4)) ?></span><br>
        <span><?= htmlspecialchars($card['expiration_date']) ?></span><br>
        <span><?= htmlspecialchars($card['card_name']) ?></span><br>
        <span data-card-id=" <?= htmlspecialchars($card['card_id']) ?>" class="delete_card"><i class="fa-solid fa-trash-can"></i></span>
        </label>
    <?php } ?>
        </section>
        <?php } else { ?>
            <section id="cards">
            <p id="noCards">You have no cards saved</p>
            </section>
        <?php } ?>
    </section>
    <button id="addCardsBtn"><i class="fa-solid fa-plus"></i></button>

</section>

<input type="hidden" name="item_sold_id" value="<?= $item_id ?>">
<input type="hidden" name="seller" value="<?= htmlspecialchars($item['seller']) ?>">
<input type="hidden" name="csrf" value="<?= $_SESSION['csrf'] ?>">
<button id="PayBtn">Pay</button>
</form>

<section id="Card_PopUp">
    <section id="Card_PopUpContent">
        <span id="closeCard" class="close">&times;</span>
        <form >
            <h2>Add a New Card</h2>
            <label for="cardName">Name on Card:</label><br>
            <input type="text" id="cardName" name="cardName" value="<?= htmlspecialchars($user['name']) ?>" required><br>

            <label for="cardNumber">Card Number:</label><br>
            <input type="text" id="cardNumber" name="cardNumber" maxlength="16" required><br>

            <label for="cardExpiry">Expiry Date (MM/YY):</label><br>
            <input type="date" id="cardExpiry" name="cardExpiry" required><br>

            <label for="cardCVV">CVV:</label><br>
            <input type="text" id="cardCVV" name="cardCVV" maxlength="4" required><br>
            <button id="PopUp_Card">Add Card</button>
        </form>
        <p id="Errormesage"></p>
    </section>
        </section>

<section id="Adress_PopUp">
            <section id="Adress_PopUpContent">
            <span id="close" class="close">&times;</span>
            <form action="../actions/action_update_adress.php" method="post">
            <h2>Change your Shipping Address</h2>
            <label for="address">Address:</label><br>
            <input type="text" id="addressC" name="address" value="<?= htmlspecialchars($user['Adress']) ?>"  required><br>
            <label for="city">City:</label><br>
            <input type="text" id="cityC" name="city" value="<?= htmlspecialchars($user['Cidade'])?>" required><br>
            <label for="Country">Country:</label><br>
            <input type="text" id="CountryC" name="Country" value="<?= htmlspecialchars($user['Country'])?>" required><br>
            <label for="zip">Zip Code:</label><br>
            <input type="text" id="zipC" name="zip" value="<?= htmlspecialchars($user['Zip_code'])?>" required><br>
            <input type="hidden" name="item_id" value="<?= htmlspecialchars($item_id) ?>">
            <input type="hidden" name="csrf" value="<?= $_SESSION['csrf'] ?>">
            <button id="PopUp_Adress">Confirm Shipping Info</button>
</form>
</section>
</section>
</section>

</main>