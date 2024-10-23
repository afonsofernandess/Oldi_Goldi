<?php 

require_once('../templates/common.php');
require_once('../templates/display_categories.php');

$db = getDatabaseConnection();
$categories = getAllCategories($db);
$brands = getAllBrands($db);
output_header($db);
display_categories($categories);

$item_id = isset($_GET['item_id']) ? urldecode($_GET['item_id']) : null;
if($item_id != null){
    $item = getItem($db,$item_id);
    $size = getSize($db,$item['size_id']);
    $brand = getBrand($db,$item['brand_id']);
    $photos = getPhotos($db,$item_id);
}
else{
    $item = null;
    $size = null;
    $brand = null;
    $photos = [];
    }
   

?>
<main id="SellItem">

<h1>Sell an Item</h1>
<section id="item_photos">
    <form action="../actions/action_sell_item.php" method="post" enctype="multipart/form-data">
        <input  id="secur" type="hidden" name="csrf" value="<?= htmlspecialchars($_SESSION['csrf']) ?>">
        <section id="img_container">
            <?php foreach($photos as $photo){ ?>  
                <div class="img-wrapper" id="photo_<?= htmlspecialchars($photo['photo_id'])?>">
                <img id="item_photo" data-photo-id="<?= htmlspecialchars($photo['photo_id']) ?>" src="<?= htmlspecialchars($photo['photo_url'])?>" width="200" height="200" alt="item photo">
                <span id="delete_image" data-item-id="<?= $item_id ?>"><i class="fa-solid fa-xmark"></i></span>
                </div>
            <?php } ?>
        </section>
        <label><input type="file" name="item_images[]" id="item_img" accept="image/png,image/jpeg" multiple></label><br>
        <label for="item_img" class ="choose_item_images">Choose Images</label><br>
        <!--<input type="hidden" id="item_hidden_input" name="img_URL" value="" >
        <input type="hidden" id="remove_img_URL" name="ImageRM" value=""> -->
        <input type="hidden" id="id_user_item" name="item_id" value="<?=$item_id?>">
        <section id = "about_item">
            Item Name:<label><input type="text" name="item_name" value="<?= isset($item['item_name']) ? htmlspecialchars($item['item_name']) : '' ?>" required></label><br>
            Description:<label><textarea name="item_description"><?= isset($item['description']) ? htmlspecialchars($item['description']) : '' ?></textarea></label><br>
        </section>
        <section id = "item_size">
            Size:
            <select name="Sell_Size" >
            <option value="Nosize" selected>No Size</option>
                <?php $sizes = getAllSizes($db);
                foreach($sizes as $size) {
                    if($size['size_id'] == $item['size_id']){?>
                        <option value="<?=htmlspecialchars($size['size_value']) ?>" selected><?= htmlspecialchars($size['size_value']) ?></option>
                    <?php } else {?>
                        <option value="<?= htmlspecialchars($size['size_value']) ?>"><?=htmlspecialchars($size['size_value']) ?></option>
                        <?php } ?>
                <?php } ?>
            </select><br>
        </section>
        <section id = "item_brand">
            Brand:
            <select name="Sell_Brand" >
                <?php $brands = getAllBrands($db);
                foreach($brands as $brand) {
                    if($brand['brand_id'] == $item['brand_id']){?>
                        <option value="<?=htmlspecialchars($brand['brand_name']) ?>" selected><?=htmlspecialchars($brand['brand_name']) ?></option>
                    <?php } else {?>
                        <option value="<?=htmlspecialchars($brand['brand_name']) ?>"><?=htmlspecialchars($brand['brand_name']) ?></option>
                        <?php } ?>
                <?php } ?>
            </select><br>
        </section>
        <section id = "item_condition">
            Condition:
            <select name="Sell_Conditions" required>
                <?php $conditions = getAllConditions($db);
                foreach($conditions as $condition) {
                    if($condition['condition_id'] == $item['condition_id']){?>
                        <option value="<?=htmlspecialchars($condition['condition_value']) ?>" selected><?=htmlspecialchars($condition['condition_value'] )?></option>
                    <?php } else {?>
                        <option value="<?=htmlspecialchars($condition['condition_value']) ?>"><?=htmlspecialchars($condition['condition_value'] )?></option>
                        <?php } ?>
                <?php } ?>
            </select><br>
        </section>
        <section id = "item_category">
            Category:
            <select name="Sell_Categories" required>
                <?php $categories = getAllCategories($db);
                foreach($categories as $category) {
                if($category['category_id'] == $item['category_id']){?>
                        <option value="<?=htmlspecialchars($category['category_name']) ?>" selected><?=htmlspecialchars($category['category_name']) ?></option>
                    <?php } else {?>
                        <option value="<?=htmlspecialchars($category['category_name'] )?>"><?=htmlspecialchars($category['category_name']) ?></option>
                        <?php } ?>
                <?php } ?>
            </select><br>
        </section>
        <section id = "item_price">
            Price:<label><input type="number" step="0.01" value="<?= htmlspecialchars($item['price']) ?>" name="item_price" placeholder="€ 0,00"redquired></label><br>
        </section>
       
        <?php if(isset($item_id)) {
        ?>
        <button type="submit" id = "sellItemButton">Confirm Changes</button>
        <?php } else { ?>
        <button type="submit" id = "sellItemButton">Sell</button>
        <?php } ?>
    </form>
</section>

</main>