<?php 
require_once('templates/common.php');
require_once('templates/display_categories.php');
$db = getDatabaseConnection();
$categories = getAllCategories($db);
$brands = getAllBrands($db);
output_header($db);
display_categories($categories);
?>


    <main>
    <section id="main_page">
    <section id="Start_buying">
    <h1>Consegues resistir a estes produtos incriveis?</h1>
    <div class="image-container">
        <img src="images/transferir.png" alt="imagem principal" id= "main_img">
        <a href="pages/items.php">Start Buying</a>
    </div>
    
    </section>
        
        <!-- Shop by brand -->
        <section id="Shop_by_brand">
        <h1>Shop by brand</h3>
        <ul>
            <?php foreach($brands as $brand) {?>
            
                <li><a href = "pages/items.php?brand_id=<?= urlencode($brand['brand_id'])?>"><?= htmlspecialchars($brand['brand_name'])?></a></li>
            <?php }?>
            </ul>
        </section>

        <!-- Popular categories -->
        <section id="Popular_categories">
            <h1>Most Popular Categories</h1>
            <?php 
            $top_categories = Popular_categories($db);
            foreach($top_categories as $tcate){
            $cate = getCategorie($db,$tcate['category_id']);?>
            <h2><a href=""><?= htmlspecialchars($cate['category_name'])?></a></h2>
            <section id="articles">
                
            <?php $items = get_Items_ByCategory($db, $cate['category_id']);

            for($i = 0; $i < 5; $i++){ 
                if ($i >= count($items)) {
                    break;
                }
                $item = $items[$i];?>
            
            <article>
            <?php $photos = getPhotos($db, $item['ItemID']); 
            ?>
            <a href="pages/item.php?item_id=<?= urlencode($item['ItemID']) ?>"><img src="<?= htmlspecialchars($photos[0]['photo_url'])?>" alt="Item 1"></a>
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
                   <?php if(isset($_SESSION['username'])){?> <i class="<?= isOnwhishlist($db,$item['ItemID'],$_SESSION['username'])? 'fa-solid fa-heart' : 'fa-regular fa-heart'?>" data-item-id="<?= htmlspecialchars($item['ItemID']) ?>">
                </i>
                <?php } ?>
            </p>
                <?php } ?>
                </section>
            </article>
            
            <?php }?>
            <article id="More">           
                 <a href="pages/items.php?category_id=<?= urlencode($tcate['category_id'])?>">See all the articles of the <?= htmlspecialchars($cate['category_name'])?> category</a>
            </article>
            </section>
            <?php }?>
        </section>

        <section id="General_articles">
            <h1>Popular Items</h1>
            <section id="Garticles">
            <?php $p_items = get_Popular_items($db);
            foreach($p_items as $item){
            $item = getItem($db,$item['item_id']);
            if($item) {?>
            <article>
            <?php $photos = getPhotos($db, $item['ItemID']); 
            ?>
            <a href="pages/item.php?item_id=<?= urlencode($item['ItemID']) ?>"><img src="<?= htmlspecialchars($photos[0]['photo_url'])?>" alt="Item 1"></a>
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
            <?php } ?>
            <?php } ?>
            </section>
        </section>
        <section id="Popular_users">
        <h1>Popular Users</h1>
        
        <?php $users = get_Top_Sellers($db);
        
        foreach($users as $user){

            $user = getUser($db, $user['seller']);
            $user_items = getItemsBySeller($db, $user['username']);
            ?>
            <section id="User">
            <section id = "U_info">
            
            <a href="pages/profile.php?username=<?= urlencode($user['username'])?>"><img src="<?= htmlspecialchars($user['photo_url'])?>" alt="profile picture"></a>
            <p><?= htmlspecialchars($user['name'])?></p>
           
            <a href="pages/profile.php?username=<?= urlencode($user['username'])?>">View more</a>

            </section>
        <section id="articles">
        <?php foreach($user_items as $item) {?>
            <article>
            <?php $photos = getPhotos($db, $item['ItemID']); 
            ?>
            <a href="pages/item.php?item_id=<?= urlencode($item['ItemID']) ?>"><img src="<?= htmlspecialchars($photos[0]['photo_url'])?>" alt="Item 1"></a>
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
        <?php }?>
            <article id="More">           
                    <a href="pages/profile.php?username=<?= urlencode($user['username']) ?>">See all the articles of <?= htmlspecialchars($user['name'])?> </a>
            </article>

            </section>
            </section>
        <?php }?>
        </section>

        
    </section>
    </main>

<?php output_footer();
?>
