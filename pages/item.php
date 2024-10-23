<?php

require_once('../templates/common.php');
require_once('../templates/display_categories.php');

$db = getDatabaseConnection();
$categories = getAllCategories($db);
$item_id = urldecode($_GET['item_id']);
if ($item_id != null) {
    output_header($db);
    display_categories($categories);
    display_item($db, $item_id);
    output_footer();
   
} else {
    header('Location: ../index.php');
    exit();
}

    function display_item($db, $item_id) {
        $item = getItem($db, $item_id);
        if(!$item) {
            $item = getSoldItem($db, $item_id);
        }
    
        $photos = getPhotos($db, $item_id);
        $brand = getBrand($db, $item['brand_id']);
        $size = getSize($db, $item['size_id']);
        $condition = getCondition($db, $item['condition_id']);
        $permissions = getUserPermissions($db, $_SESSION['username']);

        echo '<section class="product">';
            echo '<article class="product-image">';
                
                // Display thumbnails
                if (!empty($photos)) {
                    echo '<article class="product-thumbnails">';
                    foreach ($photos as $photo) {
                        echo '<img src="' . htmlspecialchars($photo['photo_url']) . '" alt="' . htmlspecialchars($item['item_name']) . '" style="width: 100px; height: auto; margin: 10px; cursor: pointer;  " onclick="changeImage(\'' . htmlspecialchars($photo['photo_url']) . '\')">';
                    }            
                    echo '</article>';
                }
                $firstPhotoUrl = $photos[0]['photo_url'] ?? 'placeholder.jpg';
                echo '<img id="mainImage" src="' . htmlspecialchars($firstPhotoUrl) . '" alt="Main Image"  ">';
                            


        echo '</article>';
        echo '<article class="product-details">';
            echo '<h1 class="product-name">'. htmlspecialchars($item['item_name']). '</h1>';
            if($item['is_sold'] == 1) {
                echo '<p class="product-sold"><b>SOLD</b></p>';
            } else {
            echo '<p class="product-price">'. htmlspecialchars($item['price']). '€</p>';
            }
            if(is_array($condition) ){
                echo '<p class="product-condition">Condition: '. htmlspecialchars($condition['condition_value']). '</p>';
            } 
            if (is_array($brand)) {
                echo '<p class="product-brand">Brand: '. htmlspecialchars($brand['brand_name']). '</p>';
            }
            if (is_array($size)) {
                echo '<p class="product-size">Size: '. htmlspecialchars($size['size_value']). '</p>';
            }
            echo '<p class="product-description">'. htmlspecialchars($item['description']). '</p>';
            
            echo '<section class="product-actions">'; 
                if($item['is_sold'] == 0){?>
                <button id="itemWhishlist" data-item-id="<?= htmlspecialchars($item_id) ?>" class="btn btn-secondary"><i id="heartItem" class="<?= isOnwhishlist($db,$item['ItemID'],$_SESSION['username'])? 'fa-solid fa-heart' : 'fa-regular fa-heart'?>"></i> Favorite</button> <?php
                if($permissions){ ?>
                <a id="edit_item_btn" href="sell.php?item_id=<?= urlencode($item['ItemID']) ?>">Edit Item</a>
                <p id="delete_item">Delete Item</p>
             
                <section id="Pop_Up_delete">
                    <section class="Pop_Up-content">
                        <p>Are you sure you want to delete this item?</p>
                        <form action="../actions/action_delete_item.php" method="post">
                            <input type="hidden" name="item_id" value="<?= htmlspecialchars($item['ItemID']) ?>">
                            <input type="hidden" name="csrf" value="<?= $_SESSION['csrf'] ?>">
                            <button id="cancelBtn">Cancel</button>
                            <button id="confirmBtn" type="submit" >Confirm</button>
                        </form>
                    
                    </section>
                </section>
                <?php if($item['seller'] != $_SESSION['username']){?>
                <button id="MBTn">Send a Message</button>
                <button id="PAPBTn">Propose another Price</button>
                <a href="Checkout.php?item_id=<?= urlencode($item['ItemID']) ?>">BUY NOW</a>
                <?php } ?>
              <?php }
                else if($item['seller'] == $_SESSION['username']){?>
                <a id="edit_item_btn" href="sell.php?item_id=<?= urlencode($item['ItemID']) ?>">Edit Item</a>
                <p id="delete_item">Delete Item</p>
                <section id="Pop_Up_delete">
                    <section class="Pop_Up-content">
                        <p>Are you sure you want to delete this item?</p>
                        <form action="../actions/action_delete_item.php" method="post">
                            <input type="hidden" name="item_id" value="<?= htmlspecialchars($item['ItemID']) ?>">
                            <input type="hidden" name="csrf" value="<?= $_SESSION['csrf'] ?>">
                            <button id="confirmBtn" type="submit" >Confirm</button>
                            <button id="cancelBtn">Cancel</button>
                        </form>
                    
                    </section>
                </section>
            <?php } else  { ?>
                
            <button id="MBTn">Send a Message</button>
            <button id="PAPBTn">Propose another Price</button>
            <a href="Checkout.php?item_id=<?= urlencode($item['ItemID']) ?>">BUY NOW</a>
            <?php } ?>
            <section id="Message_PopUp">
            <section id="Message_PopUpContent">
            <span id="close" class="close">&times;</span>
            <h2>New Message About <?= $item['item_name']?></h2>
            <form action="../actions/action_add_new_chat.php" method="post">
                <input type="hidden" name="item_id" value="<?= htmlspecialchars($item['ItemID']) ?>">
                <input type="hidden" name="user" value="<?= htmlspecialchars($item['seller']) ?>">
            <label>Message:<input type="Text" id="new_message" name="new_message"></label>
            <input type="hidden" name="csrf" value="<?= $_SESSION['csrf'] ?>">
            <button type="submit" >Send Message</button>
            </form>
            </section>
            </section>

            <section id="newPriceI_PopUp">
            <section id="NPI_PopUpContent">
            <span id="close2" class="close">&times;</span>
            <h2>Propose New Price</h2>
            <form action="../actions/action_send_new_price.php" method="post">
            <input type="hidden" name="item_id" value="<?= htmlspecialchars($item['ItemID']) ?>">
            <input type="hidden" name="user" value="<?= htmlspecialchars($item['seller']) ?>">
            <label>New Price:<input type="number" id="new_price" name="new_price"></label>
            <input type="hidden" name="csrf" value="<?= $_SESSION['csrf'] ?>">
<button type="submit" >Make Proposal</button>
</form>
</section>
</section>

                    
                <?php 
                echo '</section>';
            echo '</article>';
        echo '</section>';
    }}
    ?>