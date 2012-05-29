<?php require_once("../core/includes/initialize.php"); ?>
<?php

if ($session->is_logged_in()) {
    redirect_to("index.php");
}

// Remember to give your form's submit tag a name="submit" attribute!
if (isset($_POST['submit'])) { // Form has been submitted.
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Check database to see if username/password exist.
    $found_user = User::authenticate($username, $password);
    if ($found_user) {
        //$session = new Session();
        $session->login($found_user);
        log_action('Login', "{$found_user->username} logged in.");
        redirect_to("index.php");
    } else {
        // username/password combo was not found in the database
        $message = "Username/password combination incorrect.";
    }
} else { // Form has not been submitted.
    $username = "";
    $password = "";
}
?>

<?php include 'layouts/header.php'; ?>
<?php include 'layouts/nav.php'; ?>

<div id="signup">
<?php
if (isset($message))
    echo $message;
?>
    <form id="signupforum" method="post" action="">
        <label for="username">Username: </label>
        <input class="inputText" type="text" name="username" /><br />

        <label for="password">Password: </label>
        <input class="inputText" type="password" name="password"><br />

        <input type="submit" name="submit" value="Login" />
    </form>
</div>

<?php include 'layouts/footer.php'; ?>