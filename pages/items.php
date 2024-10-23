<?php
   
    require_once('../templates/common.php');
    require_once('../templates/display_categories.php');

    $db = getDatabaseConnection();
    $categories = getAllCategories($db);
    $brands = getAllBrands($db);
    output_header($db);
    display_categories($categories);
    $items = getAllItems($db);
    $sizes = getAllSizes($db);
    $conditions = getAllConditions($db);
    $cat_display = urldecode($_GET['category_id']);
    $brand_display = urldecode($_GET['brand_id']);
    $searchTerm = urldecode($_GET['input']);

    
?>

<main>

    
    <!-- Items for sale -->
    <section class="items">
        <aside id="Filters">
            <h3>Filters</h3>
            <?php if($searchTerm != null){ ?>
            <section id="search-term-container">
                <span id="search-term"><?= htmlspecialchars($searchTerm) ?></span>
                <span id="remove-search-term"><i class="fa-solid fa-xmark"></i></span>
            </section>
            <?php }?>
            <form>
                <?php if($searchTerm != null) {?>
                    <input type="checkbox" id="search_filter" name="search_filter" checked>
                    <?php } else { ?>
                    <input type="checkbox" id="search_filter" name="search_filter">
                <?php } ?>
                <details>
                    <summary>Size <i class="fa-solid fa-chevron-down"></i></summary>
                    <section id="sizeSection">
                        <?php foreach($sizes as $size) {?>
                        <label><input type="checkbox" id="size1" name="size1" data-size-id="<?= htmlspecialchars($size['size_id']) ?>"><?= htmlspecialchars($size['size_value'])?></label>
                        <?php }?>
                    </section>
                </details>

                <details>
                    <summary>Brand <i class="fa-solid fa-chevron-down"></i></summary>
                    <section id="brandSection">
                        <?php foreach($brands as $brand) {
                            if($brand_display == $brand['brand_id']){ ?>
                            <label><input type="checkbox" id="brand<?= htmlspecialchars($brand['brand_id'])?>" name="brand1" data-brand-id="<?= htmlspecialchars($brand['brand_id']) ?>" checked><?= htmlspecialchars($brand['brand_name'])?></label>
                          <?php } else {?>
                        <label><input type="checkbox" id="brand<? htmlspecialchars($brand['brand_id'])?>" name="brand1" data-brand-id="<?= htmlspecialchars($brand['brand_id']) ?>"><?= htmlspecialchars($brand['brand_name'])?></label>
                        <?php } ?>
                        <?php }?>
                    </section>
                </details>
                <details>
                    <summary>Condition <i class="fa-solid fa-chevron-down"></i></summary>
                    <section id="ConditionSection">
                        <?php foreach($conditions as $condition) {?>
                        <label><input type="checkbox" id="condition1" name="condition1" data-condition-id="<?= htmlspecialchars($condition['condition_id']) ?>"><?= htmlspecialchars($condition['condition_value'])?></label>
                        <?php }?>
                    </section>
                </details>
                <details>
                    <summary>Category<i class="fa-solid fa-chevron-down"></i></summary>
                    <section id="CategorySection">
                    <?php foreach($categories as $category) {
                        if($category['category_id'] == $cat_display){ ?>
                            <label><input type="checkbox" id="category<?= htmlspecialchars($category['category_id'])?>" name="category1" data-category-id="<?= htmlspecialchars($category['category_id']) ?>" checked><?= htmlspecialchars($category['category_name'])?></label>
                        <?php } else {?>
                        <label><input type="checkbox" id="category1" name="category<?= htmlspecialchars($category['category_id'])?>" data-category-id="<?= htmlspecialchars($category['category_id']) ?>"><?= htmlspecialchars($category['category_name'])?></label>
                        <?php } ?>
                        <?php }?>
                    </section>
                </details>
                <details>
                    <summary>Price<i class="fa-solid fa-chevron-down"></i></summary>
                    <section id="PriceSection">
                        <label>From:<input type="number" id="Sprice"></label><br>
                        <label>To:<input type="number" id="Finalprice"></label>

                        
                    </section>
                </details>
            </form>
        </aside>
        <section id="Item_for_sell">
            <section class = "heading">
                <h1>Items for Sale</h1>
                <div id="action_buttons">
                    <p id="Show_Filter">Hide filters <i class="fa-solid fa-sliders"></i></p>
                    <button id="ResetOrder" style="display: <?php echo $_SESSION['order'] != '0' ? 'block' : 'none'; ?>">Reset Order</button>
                    <div id="dropdownContainer">
                        
                        <p id="orderBy">Order by: <i class="fa-solid fa-chevron-down"></i></p>
                        <section id="dropdownMenu" class="dropdown-menu">
                        <?php  if($_SESSION['order'] == '1'){ ?>
                            <a id="Price_Ascend" href="#" style="color: red;">Preço: Ascendente</a>
                        <?php } else {?>
                            <a id="Price_Ascend" href="#">Preço: Ascendente</a>
                        <?php } ?>
                        <?php  if($_SESSION['order'] == '2'){ ?>
                            <a id="Price_Descend" href="#" style="color: red;">Preço: Descendente</a>
                        <?php } else {?>
                            <a id="Price_Descend" href="#">Preço: Descendente</a>
                        <?php } ?>
                        <?php  if($_SESSION['order'] == '3'){ ?>
                            <a id="Name" href="#" style="color: red;">Name</a>
                        <?php } else {?>
                            <a id="Name" href="#">Name</a>
                        <?php } ?>

                        </section>
                    </div>
                </div>
            </section>
            <section id="Garticles">
                <?php 
                
                if($cat_display != null && $searchTerm != null){
                    $items = get_ItemsByCategoryANDname($db,$searchTerm,$cat_display);
                }
                
                else if($cat_display != null){
                    $items = get_Items_ByCategory($db, $cat_display);
                    
                }
                else if($brand_display != null){
                    $items = getItemsByBrand($db,$brand_display);
                    
                    
                }
                else if($searchTerm != null){
                    $items = get_Items_ByName($db,$searchTerm);
                }
                if($_SESSION['order'] != '0'){
                usort($items, function($a, $b) {
                    return $a['price'] - $b['price'];
                });
                }
                display_items($db, $items);?>
            </section>
        </section>
    </section>

</main>
<?php output_footer(); ?>

