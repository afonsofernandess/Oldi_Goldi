<?php

    require_once('../templates/common.php');
    require_once('../templates/display_categories.php');

    $db = getDatabaseConnection();
    $categories = getAllCategories($db);
    output_header($db);
    display_categories($categories);
?>

<section id="login_register" >
    <article id="register_txt">
        <h1>Welcome!</h1>
        <p>Please fill in this form to create an account.</p>
    </article>
    <article id="form-container register">
        <form action="../actions/action_register.php" id="register_action" method="post">
            <input type="text" id="username" name="username" placeholder="Username" required><br>
            <input type="text" id="name" name="name" placeholder="Name" required><br>
            <input type="email" id="email" name="email" placeholder="Email" required><br>
            <input type="password" id="password" name="password" placeholder="Password" required><br>
            <input type="password" id="cpassword" name="cpassword" placeholder="Confirm Password" required><br><br>
            <p id="message_error_register"></p>
            <input type="hidden" name="csrf" value="<?= $_SESSION['csrf'] ?>">
            <button id="reg_button" type="submit">Register</button>
        </form>
    </article>
</section>

<?php output_footer();?>