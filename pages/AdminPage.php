<?php 

require_once('../templates/common.php');

$db = getDatabaseConnection();
output_header($db);
$category = getAllCategories($db);
$brands = getAllBrands($db);
$conditions = getAllConditions($db);
$sizes = getAllSizes($db);
$users = getAllUsers($db);
$transactions = getAllTransactions($db);
?>

<main id="Admin_Page">

<h1>Admin Page</h1>

    <section id="Insertions">
        <section id="AddCategory">
            <h2>Add Category</h2>
            <form class = "insertion_form">
                <ul id="CategoriesAdmin">
                <?php foreach($category as $cat){ ?>
                    <li><?= htmlspecialchars($cat['category_name'])?></li>
                <?php } ?>
                </ul>
                <section class="insertion_labels">
                    <label>New Category: <input type="text" id="new_category" name="category_name" required></label><br>
                    <button id="AS">Add Category</button>
                </section>
            </form>
        </section>
        <section id="AddBrand">
            <h2>Add Brand</h2>
            <form class = "insertion_form">
                <ul id="BrandsAdmin">
                <?php foreach($brands as $brand){ ?>
                    <li><?= htmlspecialchars($brand['brand_name']) ?></li>
                <?php } ?>
                </ul>
                <section class="insertion_labels">
                    <label>New Brand: <input type="text" id="new_brand" name="brand_name" required></label><br>
                    <button id="AS">Add Brand</button>
                </section>
            </form>
        </section>

        <section id="AddCondition">
            <h2>Add Condition</h2>
            <form class = "insertion_form">
                <ul id="ConditionsAdmin">
                <?php foreach($conditions as $condition){ ?>
                    <li><?= htmlspecialchars($condition['condition_value']) ?></li>
                <?php } ?>
                </ul>
                <section class="insertion_labels">
                    <label>New Condition: <input type="text" id="new_condition" name="condition_value" required></label><br>
                    <button id="AS">Add Condition</button>
                </section>
            </form>
        </section>

        <section id="AddSize">
            <h2>Add Size</h2>
            <form class = "insertion_form">
                <ul id="SizesAdmin">
                <?php foreach($sizes as $size){ ?>
                    <li><?= htmlspecialchars($size['size_value']) ?></li>
                <?php } ?>
                </ul>
                <section class="insertion_labels">
                    <label>New Size: <input type="text" id="new_size" name="size_value" required></label><br>
                    <button id="AS">Add Size</button>
                </section>
            </form>
        </section>
    </section>
    <section id="Users">
        <h2>Users</h2>
        <ul class = "users_grid">
        <?php foreach($users as $user){ 
            if($user['username'] != $_SESSION['username']){?>
            <section id="individual_user">
                <a href="profile.php?username=<?= urlencode($user['username']) ?>"><li><img width="50" height="50" src="<?= htmlspecialchars($user['photo_url']) ?>" alt="profile_picutre">
                <p><?= htmlspecialchars($user['username']) ?>(<?= htmlspecialchars($user['name']) ?>)</p>
                <p>Item for Sale: <?= htmlspecialchars(NumberItemForSale($db,$user['username']))  ?></p>
                <p>Items Sold: <?= htmlspecialchars(NumberItemsSold($db,$user['username'])) ?></p>
                </li></a>
            </section>
        <?php } ?>
        <?php } ?>
        </ul>
    </section>

    <section id="Transactions">
        <h2>Transactions</h2>
        <ul class = "transactions_grid">
            <?php foreach($transactions as $transaction){ 
                $item = getSoldItem($db,$transaction['item_id']);
                $new_price = getNewPrice($db,$_SESSION['username'],$transaction['item_id']);
                ?>
            <section id="individual_transaction">
                <li>
                    <p>Buyer: <?= htmlspecialchars($transaction['buyer']) ?></p>
                    <p>Seller: <?= htmlspecialchars($transaction['seller']) ?></p>
                    <p>Item: <?= htmlspecialchars($item['item_name']) ?></p>
                    <?php if($new_price) {?>
                    <p>Price: <?= $new_price?>€</p>
                    <?php } else { ?>
                        <p>Price: <?= htmlspecialchars($item['price']) ?>€</p>
                    <?php } ?>
                    <p>Date: <?= htmlspecialchars($transaction['transaction_date']) ?></p>
                </li>
            </section>
            <?php } ?>
        </ul>
    </section>
</main>

<?php output_footer(); ?>