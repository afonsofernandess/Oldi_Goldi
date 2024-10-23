<?php 

require_once('../templates/common.php');
require_once('../templates/display_categories.php');

$db = getDatabaseConnection();
$categories = getAllCategories($db);
$brands = getAllBrands($db);
output_header($db);
display_categories($categories);
$usernams = urldecode($_GET['username']);
$user = getUser($db,$usernams);
?>

<main id = "edit_profile_main">
    <section class="edit">
    <h1>Update your profile</h1>
        <form method="post" action="../actions/action_update_profile.php" id="edit_profile " enctype="multipart/form-data">
            <section id="update_profile">
                <section id="user_picture">
                    <h2>Your picture</h2>
                    <img id="profilePicture" src="<?= isset($user['photo_url']) ? htmlspecialchars($user['photo_url']) : '' ?>" alt="profile picture">
                <input type="hidden" id="hidden_input" name="imgSrc" value="">
                <input type="file" id="fileInput">
                <label for="fileInput" class="choose_profile_picture">Change Profile Picture</label><br>
                <label id="updateProfileLabel">About you: <textarea name="description" id="About_you" placeholder="Let everyone know more about you!"><?= isset($user['description']) ? htmlspecialchars($user['description']) : '' ?></textarea></label>
                </section>
                <section id="user_details">
                    <h2>User Details</h2>
                    <label id="updateProfileLabelEmail">Email: <input type="text" id="updateProfileTextEmail" value="<?= isset($user['email']) ? htmlspecialchars($user['email']) : '' ?>" name="email" id="email"></label>
                    <label id="updateProfileLabelName">Name: <input type="text" id="updateProfileTextName" value="<?= isset($user['name']) ? htmlspecialchars($user['name']) : '' ?>" name="name" id="name"></label>
                    <label id="updateProfileLabelPhoneNumber">Phone Number: <input type="text" id="updateProfileTextPhoneNumber" value="<?= isset($user['phone_number']) ? htmlspecialchars($user['phone_number']) : '' ?>" name="pn" id="pn"></label>
                </section>
                <section id="shipping">
                    <h2>Shipping Information</h2>

                    <label id="updateProfileLabelAdress">Adress: <input type="text" id="updateProfileTextAdress" value="<?= isset($user['Adress']) ? htmlspecialchars($user['Adress']) : '' ?>" name ="address"></label>
                    <label id="updateProfileLabelZipCode">Zip-Code: <input type="text" id="updateProfileTextZipCode" value="<?= isset($user['Zip_code']) ? htmlspecialchars($user['Zip_code']) : '' ?>" name="ZP" id="XP"></label>
                    <label id="updateProfileLabelCountry">Country: <input type="text" id="updateProfileTextCountry" value="<?= isset($user['Country']) ? htmlspecialchars($user['Country']) : '' ?>" name="Country" id="Country"></label>
                    <label id="updateProfileLabelCity">City: <input type="text" id="updateProfileTextCity" value="<?= isset($user['Cidade']) ? htmlspecialchars($user['Cidade']) : '' ?>" name="City" id="City">
                </section>
            </section>
            <input type="hidden" name="csrf" value="<?= $_SESSION['csrf'] ?>">
            <button type="submit" id="updateProfileButton">Update Profile</button>
        </form>
    </section>
</main>

<?php output_footer();
?>