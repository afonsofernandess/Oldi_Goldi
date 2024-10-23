<?php
require_once(__DIR__ . '/../database/connection.php');
require_once(__DIR__ . '/../database/categories.php');
require_once(__DIR__ . '/../database/users.php');
require_once(__DIR__ . '/../database/is_on_whishlist.php');
require_once(__DIR__ . '/../database/chats.php');


session_set_cookie_params([
    'lifetime' => 0,
    'path' => '/',
    'domain' => '', 
    'secure' => false, 
    'httponly' => true,
    'samesite' => 'Strict', 
]);

session_start();

function generate_random_token(){
    return bin2hex(openssl_random_pseudo_bytes(32));
}

if(!isset($_SESSION['csrf'])){
    $_SESSION['csrf'] = generate_random_token();
}
function output_header($db){ ?>
    <!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/login.css">
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/items.css">
    <link rel="stylesheet" href="../css/edit_profile.css">
    <link rel="stylesheet" href="../css/item.css">
    <link rel="stylesheet" href="../css/profile.css">
    <link rel="stylesheet" href="../css/sell.css">
    <link rel="stylesheet" href="../css/messages.css">
    <link rel="stylesheet" href="../css/Checkout.css">
    <link rel="stylesheet" href="../css/admin_page.css">
    <link rel="stylesheet" href="../css/chats.css">
    <link rel="stylesheet" href="../css/ShippingForm.css">

    <script src="../javascript/items.js" defer></script>
    <script src="../javascript/script.js" defer></script>
    <script src="../javascript/update_profile.js" defer></script>
    <script src="../javascript/change_password.js" defer></script>
    <script src="../javascript/register.js" defer></script>
    <script src="../javascript/search.js" defer></script>
    <script src="../javascript/messages.js" defer></script>
    <script src="../javascript/checkout.js" defer></script>
    <script src="../javascript/admin.js" defer></script>
    <script src="../javascript/item.js"></script>

    <script src="https://kit.fontawesome.com/2b8a00114a.js" crossorigin="anonymous"></script>
    <meta charset="UTF-8">

    <title>Oldi Goldi</title>
</head>
<body>
    <header>
        <section id="main_nav_bar">
        <h1><a href = "../index.php"><img src="../images/logo.png" alt="Shop Logo" height="70" ></a></h1> 
        <section id = "navsection">
        <form action="../actions/action_search.php" method="get">
            <select id="Select_Categories" name="Categories">
            <option value="All" selected>All Categories</option>
            <?php $categories = getAllCategories($db);
            foreach($categories as $category) {?>
            <option value="<?= htmlspecialchars($category['category_name']) ?>"><?= htmlspecialchars($category['category_name']) ?></option>
            <?php } ?>
            </select>
            <!-- Search bar -->
            <section class = "searchbar">
                <input id = "search" type = "text" placeholder = "Find your dream item!" name="inputbar" oninput="searchFunction()">
                <section id="searchResult"></section>
            </section>
            <button type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
        </form>
        </section>
        <div class="navbar-right">
            <?php if(isset($_SESSION['username'])) { ?>
            <div class="icon-links">
                <a href="../pages/chats.php"><i class="fa-solid fa-message"></i></a>
                <a href="../pages/wish_list.php"><i class="fa-solid fa-heart"></i></a>
            </div>
             
            <?php } ?>
            <?php if(isset($_SESSION['username'])) {
            $permission = getUserPermissions($db,$_SESSION['username']);?>
            <section id="loged_in">
            <?php if($permission){ ?>
            <a href="../pages/AdminPage.php" id="admin">Admin Page</a>
            <?php } ?>
            <a href="../pages/profile.php" id="profile"><i class="fa-solid fa-user"></i></a>
            <a href="../pages/sell.php" id="Sell_now">Sell Now</a>
            <a href="../actions/action_logout.php" id="logout">Logout</a>
            </section>
            <?php } 
            else { ?>
                <div id="signup">
                <a href = "../pages/login.php">Login</a>
                <a href = "../pages/register.php">Register</a>
                </div>
            <?php } ?>

        </div>
      </section>
    </header>

<?php } ?>

<?php function output_footer(){ ?>

    <footer>
    <p>&copy; 2024 Oldi Goldi. All rights reserved.</p>
    </footer>
    </body>
</html>
<?php }?>