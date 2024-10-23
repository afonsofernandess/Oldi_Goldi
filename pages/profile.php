<?php 

require_once('../templates/common.php');
require_once('../templates/display_categories.php');

$db = getDatabaseConnection();
$categories = getAllCategories($db);
$brands = getAllBrands($db);
output_header($db);
display_categories($categories);
$pageOwner = isset($_GET['username']) ? urldecode($_GET['username']) : null;

if($pageOwner != null)$user = getUser($db,$pageOwner);
else $user = getUser($db,$_SESSION['username']);


$permissions = getUserPermissions($db,$_SESSION['username']);
?>

<main id="user_profile">
  <section id="passwordPopUp" class="PopUp">
    <section class="PopUpcontent">
      <span id="close" class="close">&times;</span>
      <h2>Change Password</h2>
      <form id="passwordForm" action="../actions/action_update_password.php" method="post">
        <label>Current Password: <input type="password" name="Cpassword" required></label><br>
        <label>New Password: <input type="password" name="npassword"></label><br>
        <label>Confirm new Password: <input type="password" name="cnpassword"></label><br>
        <p id="message_error"></p>
        <input type="hidden" name="csrf" value="<?= $_SESSION['csrf'] ?>">
        <button id="ConfirmChangesBtn">Confirm Changes</button>
      </form>
    </section>
  </section>
  
  <section id="deleteUserPopUp" class="PopUp">
    <section id="DeletePopUpcontent">
      <span id="closeDeleteUser" class="close">&times;</span>
      <h2>Delete User</h2>
      <p>Are you sure you want to delete this user?</p>
      <form action="../actions/action_profile.php" method="post">
        <input type="hidden" name="user" value="<?= htmlspecialchars($user['username'])?>">
        <input type="hidden" name="action" value="delete">
        <input type="hidden" name="csrf" value="<?= $_SESSION['csrf'] ?>">
        <button id="confirmDeleteUser">Yes, Delete User</button>
        <button id="cancelDeleteUser">No, Cancel</button>
      </form>
    </section>
  </section>

  <section id="Info">
    <section class="user_profile_picture">
      <img src="<?= htmlspecialchars($user['photo_url'])?>" alt="profile picture">
    </section>
    <section class="user_profile_details">
      <p id="user_name"><?= htmlspecialchars($user['name']) ?></p>
      <?php if($user['isAdmin']){ ?>
        <p id="user_username"><?= htmlspecialchars($user['username']) ?>(Admin)</p>
      <?php } else { ?>
        <p id="user_username"><?= htmlspecialchars($user['username']) ?></p>
      <?php } ?>
      <?php if(isset($user['Cidade']) || isset($user['Country'])){ ?>
        <p><i class="fa-solid fa-location-dot"></i> <?= htmlspecialchars($user['Cidade'])?>, <?= htmlspecialchars($user['Country'])?></p>
      <?php } ?>
      <section id="Personal_Info">
        <h3>Contacts</h3>
        <span class="email"><i class="fa fa-envelope" aria-hidden="true"></i> <?= htmlspecialchars($user['email'])?></span><p></p>
        <?php if(isset($user['phone_number'])){ ?> 
          <span class="phonenumber"><i class="fa fa-phone" aria-hidden="true"></i> <?= htmlspecialchars($user['phone_number'])?></span><p></p>
        <?php } ?>
        <?php if(isset($user['Adress'])) {?><span class="address"><i class="fa fa-home" aria-hidden="true"></i> <?= htmlspecialchars($user['Adress'])?></span> <?php } ?>
        <?php if(isset($user['Zip_code'])){ ?> 
          <span class="zip_code"><?= htmlspecialchars($user['Zip_code'])?></span>
        <?php } ?>
      </section>
      <?php if(isset($user['description'])){ ?> 
        <p><?= htmlspecialchars($user['description'])?></p>
      <?php } ?>
      <?php if ($pageOwner != null && !$user['isAdmin'] && $permissions){?>
        <form action="../actions/action_profile.php" method="post">
          <input type="hidden" name="user" value="<?= htmlspecialchars($user['username']) ?>">
          <input type="hidden" name="action" value="elevate">
          <input type="hidden" name="csrf" value="<?= $_SESSION['csrf'] ?>">
          <button id="ElevateUser">ElevateUserToAdmin</button>
        </form>
        <button id="DeleteUSer">Delete User</button>
      <?php } else if($pageOwner == null){?>
        <a href="edit_profile.php?username=<?= urlencode($_SESSION['username']) ?>" id="EditProfileButton">Edit your profile</a>
        <button id="changePasswordBtn">Change Password</button>
      <?php } ?>
    </section>
  </section>

  

  <?php 
  $user_items = getItemsBySeller($db, $user['username']);
  if(count($user_items) < 1){ ?>
    <section id="ProfileStartSelling">
      <?php if($pageOwner == null) {?>
        <h3>List items to start selling</h3>
        <a href="sell.php" id="SellNowButton">Sell Now</a>
      <?php } else { ?>
        <h3>This user has no items for sale</h3>
      <?php } ?>
    </section>
  <?php } ?>

  <?php if(count($user_items) >= 1){ ?>
    <section id="GarticlesProfile">
      <?php foreach($user_items as $item) { ?>
        <article>
          <?php 
          $photos = getPhotos($db, $item['ItemID']); 
          ?>
          <a href="item.php?item_id=<?= urlencode($item['ItemID']) ?>"><img src="<?= htmlspecialchars($photos[0]['photo_url'])?>" alt="Item" height="300" width="50"></a>
          <section class="article-info">
            <h2><?= htmlspecialchars($item['item_name'])?></h2>
            <p><?= htmlspecialchars($item['price'])?>€</p>
            <?php 
            $brand = getBrand($db, $item['brand_id']);
            if (is_array($brand) && !empty($brand['brand_name'])) { ?>
              <p><?= htmlspecialchars($brand['brand_name'])?></p>
            <?php } ?>
            <?php 
            $size = getSize($db, $item['size_id']);
            if (is_array($size) && !empty($size['size_value'])) { ?>
              <p><?= htmlspecialchars($size['size_value'])?></p>
            <?php } ?>
            <?php 
            $condition = getCondition($db, $item['condition_id']);
            if (is_array($condition) && !empty($condition['condition_value'])) { ?>
              <p id="heart"><?= htmlspecialchars($condition['condition_value'])?> 
                <?php if($pageOwner != null){ if(isset($_SESSION['username'])){?> 
                  <i class="<?= isOnwhishlist($db,$item['ItemID'],$_SESSION['username'])? 'fa-solid fa-heart' : 'fa-regular fa-heart'?>" data-item-id="<?= $item['ItemID'] ?>">
                  </i>
                <?php } }?>
              </p>
            <?php } ?>
          </section>
        </article>
      <?php } ?>
    </section>
  <?php } ?>

  <?php 
  $transactions = getTransactionsByUser($db,$user['username']);
  if(($pageOwner == null || ($pageOwner == null && !$user['isAdmin'] && $permissions)) && count($transactions) > 0){ ?>
    <section id="User_Transactions">
      <h2>Transactions</h2>
      <ul>
        <?php foreach($transactions as $transaction){ 
          $item = getSoldItem($db,$transaction['item_id']);
          $new_price = getNewPrice($db,$user['username'],$transaction['item_id']);
          $photos = getPhotos($db, $transaction['item_id']);
        ?>
          <li>
            <img src="<?= htmlspecialchars($photos[0]['photo_url'])?>" alt="Item Photo" class="transaction-item-photo">
            <section class="transaction-info">
              <?php if($transaction['buyer'] == $user['username']){ ?>
                <p>Purchased from: <?= htmlspecialchars($transaction['seller']) ?></p>
              <?php } else { ?>
                <p>Sold to: <?= htmlspecialchars($transaction['buyer']) ?></p>
              <?php } ?>
              <p>Item: <a href="item.php?item_id=<?= urlencode($item['ItemID'])?>"><?= htmlspecialchars($item['item_name']) ?></a></p>
              <?php if($new_price) { ?>
                <p>Price: <?= $new_price?>€</p>
              <?php } else { ?>
                <p>Price: <?= htmlspecialchars($item['price']) ?>€</p>
              <?php } ?>
              <p>Date: <?= htmlspecialchars($transaction['transaction_date']) ?></p>
              <?php if($transaction['buyer'] == $user['username']){ ?>
                <a href="ShippingForm.php?item_id=<?= urlencode($item['ItemID']) ?>">Get Shipping Form</a>
              <?php } ?>
            </section>
          </li>
        <?php } ?>
      </ul>
    </section>
  <?php } ?>
</main>


<?php output_footer();
?>