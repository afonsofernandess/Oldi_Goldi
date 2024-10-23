<?php 
function display_categories($categories){
?>

<input type="checkbox" id="hamburger"> 
<label class="hamburger" for="hamburger"></label>

<ul id="Category_filters">
    <?php foreach($categories as $categorie){?>
            <li><a href = "../pages/items.php?category_id=<?= urlencode($categorie['category_id']) ?>"><?= htmlspecialchars($categorie['category_name'])?></a></li>
    <?php } ?>
        </ul>
       
</header>

<?php }?>