<?php 

require_once('../templates/common.php');
require_once('../templates/display_categories.php');

$db = getDatabaseConnection();
$categories = getAllCategories($db);
$brands = getAllBrands($db);
output_header($db);
display_categories($categories);

?>

<main>
<section id="Wlist">
<h1>Wish List</h1>

<section id="Garticles">
<?php 
$items = getItemsByWhislist($db, $_SESSION['username']);
if(empty($items)){ ?>
    <h2>There are no items in your wishlist</h2>
    <a href="items.php">Look for some in here</a>
<?php } else {
foreach($items as $Witem){ 
    $item = getItem($db,$Witem[0]);
    if($item){?>
<article>
<?php $photos = getPhotos($db, $item['ItemID']);
?>
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
                    <i class="<?= isOnwhishlist($db,$item['ItemID'],$_SESSION['username'])? 'fa-solid fa-heart' : 'fa-regular fa-heart'?>" data-item-id="<?= htmlspecialchars($item['ItemID']) ?>">
                </i></p>
                <?php } ?>
    </section>
</article>
<?php }?>
<?php }
    } ?>
           
            
    </section>
</section>
</main>