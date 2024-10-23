<?php
require_once('is_on_whishlist.php');
    function getAllBrands($db){
        $stmt = $db -> prepare('SELECT * FROM Brands');
        $stmt->execute();
        $brands = $stmt->fetchAll();
        return $brands;
    }
    function getAllCategories($db){
        $stmt = $db->prepare('SELECT * FROM Categories');
        $stmt->execute();
        $categories = $stmt->fetchAll();
        return $categories;
    }

    function getCategorieByName($db,$category_name){
        $stmt = $db->prepare("SELECT category_id from Categories where category_name = ?");
        $stmt->execute(array($category_name));
        return $stmt->fetchColumn();
    }
    function getSizeByName($db,$size_name){
        $stmt = $db->prepare("SELECT size_id from Sizes where size_value = ?");
        $stmt->execute(array($size_name));
        return $stmt->fetchColumn();
    }

    function getBrandByName($db,$brand_name){
        $stmt = $db->prepare("SELECT brand_id from Brands where brand_name = ?");
        $stmt->execute(array($brand_name));
        return $stmt->fetchColumn();
    }
    function getAllItems($db){
        $stmt = $db->prepare('SELECT * FROM Item where is_sold = 0');
        $stmt->execute();
        $items = $stmt->fetchAll();
        return $items;
    }


    function getAllConditions($db){
        $stmt = $db->prepare('SELECT * FROM Conditions');
        $stmt->execute();
        $conditions = $stmt->fetchAll();
        return $conditions;
    }
    function getAllSizes($db){
        $stmt = $db->prepare('SELECT * FROM Sizes');
        $stmt->execute();
        $sizes = $stmt->fetchAll();
        return $sizes;
    }
    
    function getBrand($db, $brand_id){
        $stmt = $db->prepare('SELECT brand_name FROM Brands WHERE brand_id = ?');
        $stmt->execute(array($brand_id));
        $brand = $stmt->fetch();
        return $brand;
    }
    function getSize($db,$size_id){
        $stmt = $db->prepare('SELECT size_value FROM Sizes WHERE size_id = ?');
        $stmt->execute(array($size_id));
        $size = $stmt->fetch();
        return $size;
    }
    function getPhotos($db,$item_id){
        $stmt = $db->prepare('SELECT * FROM Photos WHERE item_id = ?');
        $stmt->execute(array($item_id));
        $photos = $stmt->fetchAll();
        return $photos;
    }

    

    function getItem($db, $item_id) {
        $stmt = $db->prepare("SELECT * FROM Item WHERE ItemID = ? and is_sold = 0");
        $stmt->execute([$item_id]);
        return $stmt->fetch();
    }

    function getSoldItem($db, $item_id) {
        $stmt = $db->prepare("SELECT * FROM Item WHERE ItemID = ? AND is_sold = 1");
        $stmt->execute(array($item_id));
        return $stmt->fetch();
    }
    function getCategorie($db, $categorie_id) {
        $stmt = $db->prepare("SELECT * FROM Categories WHERE category_id = ?");
        $stmt->execute([$categorie_id]);
        return $stmt->fetch();
    }
    
    function getCondition($db, $condition_id) {
        $stmt = $db->prepare("SELECT condition_value FROM Conditions WHERE condition_id = ?");
        $stmt->execute([$condition_id]);
        return $stmt->fetch();
    }
    function Popular_categories($db){

        $stmt = $db->prepare("SELECT category_id, count(*) as Item_count FROM Item where is_sold = 0 GROUP BY category_id ORDER BY Item_count DESC LIMIT 2");
        $stmt->execute();
        return $stmt->fetchAll();
    }
    function get_Items_ByCategory($db, $category_id){
        $stmt = $db->prepare("SELECT * FROM Item where category_id = ? and is_sold = 0");
        $stmt->execute([$category_id]);
        return $stmt->fetchAll();
    }


    function get_ItemsByCategoryANDname($db,$name,$categorie_id){
        $stmt = $db->prepare("SELECT * FROM Item where category_id = ? AND is_sold = 0 AND item_name LIKE ?");
        $stmt->execute(array($categorie_id,"%$name%"));
        return $stmt->fetchAll();
    }


    function getItemsByUser($db, $username){
        $stmt = $db->prepare('SELECT * FROM Item WHERE is_sold = 0 AND username = ?');
        $stmt->execute(array($username));
        return $stmt->fetchAll();

    }
    function getItemsBySizes($db, $size_ids){
        $size_ids_str = implode(',', $size_ids); //this joins the element of the array with a comma
        $stmt = $db->prepare("SELECT * FROM Item WHERE is_sold = 0 AND size_id IN ($size_ids_str)");
        $stmt->execute();
        $items = $stmt->fetchAll();
        return $items;
    }
    function getItemsByBrand($db, $brand_id){
        $stmt = $db->prepare("SELECT * FROM Item WHERE is_sold = 0 AND brand_id = ?");
        $stmt->execute(array($brand_id));
        $items = $stmt->fetchAll();
        return $items;
    }

  
    function getItemsByWhislist($db, $username){
        $stmt = $db->prepare('SELECT item_id FROM Whishlists WHERE username = ?');
        $stmt->execute(array($username));
        $items = $stmt->fetchAll();
        return $items;
    }

    function getItemsBySeller($db, $seller){
        $stmt = $db->prepare('SELECT * FROM Item WHERE is_sold = 0 AND seller = ?');
        $stmt->execute(array($seller));
        $items = $stmt->fetchAll();
        return $items;
    }

    function get_Top_Sellers($db){
        $stmt = $db->prepare('SELECT seller, count(*) as Item_count FROM Transactions GROUP BY seller ORDER BY Item_count DESC LIMIT 3');
        $stmt->execute();
        return $stmt->fetchAll();
    }

    function getUser($db, $username){
        $stmt = $db->prepare('SELECT * FROM Users WHERE username = ?');
        $stmt->execute(array($username));
        return $stmt->fetch();
    }

    function display_items($db, $items){
        foreach($items as $item) {?>
            <article>
                <?php $photos = getPhotos($db, $item['ItemID']);?>
                <a href="item.php?item_id=<?= urlencode($item['ItemID']) ?>"><img src="<?= htmlspecialchars($photos[0]['photo_url'])?>" alt="Item 1"></a>
                <section class="article-info">
                    <h2><?= htmlspecialchars($item['item_name'])?></h2>
                    <p><?= htmlspecialchars($item['price'])?>€</p>
                    <?php $brand = getBrand($db, $item['brand_id']);
                    if (is_array($brand) && !empty($brand['brand_name'])) { ?>
                        <p><?= htmlspecialchars($brand['brand_name'])?></p>
                    <?php } ?>
                    <?php $size = getSize($db, $item['size_id']); 
                    if (is_array($size) && !empty($size['size_value'])) { ?>
                        <p><?= htmlspecialchars($size['size_value'])?></p>
                    <?php } ?>
                    <?php $condition = getCondition($db, $item['condition_id']); 
                    if (is_array($condition) && !empty($condition['condition_value'])) { ?>
                         <p id="heart"><?= htmlspecialchars($condition['condition_value'])?> 
                         <?php if(isset($_SESSION['username'])){?> <i class="<?= isOnwhishlist($db,$item['ItemID'],$_SESSION['username'])? 'fa-solid fa-heart' : 'fa-regular fa-heart'?>" data-item-id="<?= $item['ItemID'] ?>">
                </i>
                <?php } ?>
            </p>
                    <?php } ?>
                </section>
            </article>
        <?php }
    }

    function getItemPrice($db, $item_id){
        $stmt = $db->prepare('SELECT price FROM Item WHERE ItemID = ?');
        $stmt->execute(array($item_id));
        return $stmt->fetchColumn();
    }

    function get_Popular_items($db){

        $stmt = $db->prepare("SELECT item_id, count(*) as Item_count from Whishlists Group BY item_id ORDER BY Item_count DESC LIMIT 10");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    function display_results($results){
        foreach($results as $result){?>
        <li><a href="../pages/item.php?item_id=<?= urlencode($result['ItemID']) ?>"><?= htmlspecialchars($result['item_name']) ?></a></li>
        <?php }
    }

    function get_Items_ByName($db,$name){
        $stmt = $db->prepare("SELECT * from Item where is_sold = 0 AND item_name like ?");
        $stmt->execute(array("%$name%"));
        return $stmt->fetchAll();
    }
    
    function getCurrentItem_id($db){
        $stmt = $db->prepare("SELECT MAX(ItemID) FROM Item where is_sold = 0");
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    function getCurrentSize_id($db){
        $stmt = $db->prepare("SELECT MAX(size_id) FROM Sizes");
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    function getCurrentBrand_id($db){
        $stmt = $db->prepare("SELECT MAX(brand_id) FROM Brands");
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    function getCurrentPhoto_id($db){
        $stmt = $db->prepare("SELECT MAX(photo_id) FROM Photos");
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    function getConditionByName($db,$condition_name){
        $stmt = $db->prepare("SELECT condition_id from Conditions where condition_value = ?");
        $stmt->execute(array($condition_name));
        return $stmt->fetchColumn();
    }

    function getMessage($db,$message_id){
        $stmt = $db->prepare("SELECT * FROM messages WHERE message_id = ?");
        $stmt->execute([$message_id]);
        return $stmt->fetch();
    }

    function getNewPrice($db,$username,$item_id){
        $stmt = $db->prepare("SELECT MIN(proposed_price) FROM UserPrices WHERE username = ? and ItemID = ?");
        $stmt->execute(array($username,$item_id));
        return $stmt->fetchColumn();
    }

    function displayPhotosByItem($photos,$item_id){

        foreach($photos as $photo){ ?>  
            <div class="img-wrapper">
            <img id="item_photo" src="<?= htmlspecialchars($photo['photo_url'])?>" width="200" height="200" alt="item photo">
            <span id="delete_image" data-item-id="<?= $item_id ?>"><i class="fa-solid fa-xmark"></i></span>
            
            </div>
        <?php } 

    }

    function getCards($db,$username){
        $stmt = $db->prepare("SELECT * FROM Cards WHERE username = ?");
        $stmt->execute(array($username));
        return $stmt->fetchAll();
    }

    function addNewCard($db,$cardNumber,$cardName,$cardExpDate,$cardCVV){
        $stmt = $db->prepare("INSERT INTO Cards (card_number,card_name,username,expiration_date,cvv) VALUES (?,?,?,?,?)");
        $stmt->execute(array($cardNumber,$cardName,$_SESSION['username'],$cardExpDate,$cardCVV));
    }

    function getAllUsers($db){
        $stmt = $db->prepare("SELECT * FROM Users");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    function getAllTransactions($db){
        $stmt = $db->prepare("SELECT * FROM Transactions");
        $stmt->execute();
        return $stmt->fetchAll();
    }
   
    function NumberItemsSold($db,$username){
        $stmt = $db->prepare("SELECT count(*) FROM Transactions WHERE seller = ?");
        $stmt->execute(array($username));
        return $stmt->fetchColumn();
    }

    function NumberItemForSale($db,$username){
        $stmt = $db->prepare("SELECT count(*) FROM Item WHERE seller = ? AND is_sold = 0");
        $stmt->execute(array($username));
        return $stmt->fetchColumn();
    }

   function addCard($db,$cardNumber, $cardName, $cardExpDate, $cardCVV){ ?>

    <label ><input type="radio" id="input_<?= $db->lastInsertId(); ?>" name="card" value="<?= htmlspecialchars($db->lastInsertId()) ?>" required>
        <?php if($cardNumber[0] == '2' || $cardNumber[0] == '5'){ ?>
            <span>Mastercard</span><br>
        <?php } else if($cardNumber[0] == '4'){ ?>
            <span>Visa</span><br>
        <?php } else if($cardNumber[0] == '3'){ ?>
            <span>American Express</span>
        <?php } ?>
        <span>**** **** **** <?= htmlspecialchars(substr($cardNumber, -4)) ?></span><br>
        <span><?= htmlspecialchars($cardExpDate) ?></span><br>
        <span><?= htmlspecialchars($cardName) ?></span><br>
        <span data-card-id="<?= htmlspecialchars($db->lastInsertId()) ?>" class="delete_card"><i class="fa-solid fa-trash-can"></i></span>
    </label>
    <?php 
   }

   function getTransaction($db,$item_id){
       $stmt = $db->prepare("SELECT * FROM Transactions WHERE item_id = ?");
       $stmt->execute(array($item_id));
       return $stmt->fetch();
   }

   function getTransactionsByUser($db,$username){
       $stmt = $db->prepare("SELECT * FROM Transactions WHERE seller = ? OR buyer = ?");
       $stmt->execute(array($username,$username));
       return $stmt->fetchAll();
   }

   function getItemsByOrder($db,$order){
        if($order == '1') $stmt = $db->prepare("SELECT * FROM Item WHERE is_sold = 0 ORDER BY price ASC");
        else if($order == '2') $stmt = $db->prepare("SELECT * FROM Item WHERE is_sold = 0 ORDER BY price DESC");
        else if($order == '3') $stmt = $db->prepare("SELECT * FROM Item WHERE is_sold = 0 ORDER BY item_name ASC");
       $stmt->execute();
       return $stmt->fetchAll();
   }
?>