<?php require_once("../core/includes/initialize.php"); ?>
<?php
if ($session->is_logged_in()) {
    redirect_to("index.php");
}

// Remember to give your form's submit tag a name="submit" attribute!
if (isset($_POST['submit'])) { // Form has been submitted.
    if (isset($_POST['user_name'])) {
        //the user name exists
        if (!ctype_alnum($_POST['user_name'])) {
            $errors[] = 'The username can only contain letters and digits.';
        }
        if (strlen($_POST['user_name']) > 30) {
            $errors[] = 'The username cannot be longer than 30 characters.';
        }
    } else {
        $errors[] = 'The username field must not be empty.';
    }


    if (isset($_POST['user_pass'])) {
        if ($_POST['user_pass'] != $_POST['user_pass_check']) {
            $errors[] = 'The two passwords did not match.';
        }
    } else {
        $errors[] = 'The password field cannot be empty.';
    }
    
    if (empty($errors)):
        $user = new User();
        $user->username = trim($_POST['user_name']);
        $user->password = sha1(trim($_POST['user_pass']));
        $user->user_email = trim($_POST['user_email']);
        $user->first_name = trim($_POST['fname']);
        $user->last_name = trim($_POST['lname']);
        $user->user_level = trim($_POST['level']);
        if ($user->create() ):
            $message = 'Succesfully registered. You can now <a href="signin.php">sign in</a> and start posting!';
        else:
            $message = "Something went wrong while registering. Please try again later.";
        endif;
    endif;
}
?>

<?php include 'layouts/header.php'; ?>
<?php include 'layouts/nav.php'; ?>
<div id="signup">
    <?php
    if(isset($message)):
        echo "<p>$message</p>";
    endif;
    if (isset($errors)):
        echo 'Uh-oh.. a couple of fields are not filled in correctly..<br /><br />';
        echo '<ul>';
        foreach ($errors as $key => $value) /* walk through the array so all the errors get displayed */ {
            echo '<li>' . $value . '</li>'; /* this generates a nice error list */
        }
        echo '</ul>';
    endif;
    ?>
    <form id="signupforum" method="post" action="">
        <label for="fname">First name: </label>
        <input class="inputText" type="text" placeholder="First Name" name="fname" autofocus /><br />
        
        <label for="lname">Last name: </label>
        <input class="inputText" type="text" placeholder="Family Name" name="lname" /><br />
        
        <label for="user_name">Username: </label>
        <input class="inputText" maxlength="30" placeholder="Username" pattern="[a-zA-Z ]{5,}" type="text" name="user_name" required /><br />

        <label for="user_pass">Password: </label>
        <input class="inputText" type="password" name="user_pass" required /><br />

        <label for="user_pass_check">Password again: </label>
        <input class="inputText" type="password" name="user_pass_check" required /><br />

        <label for="user_email">E-mail: </label>
        <input class="inputText" type="email" placeholder="valid email address" name="user_email" required /><br />
        
        <input type="hidden" name="level" value="1" />
        <input type="submit" name="submit" value="Sign Up" />
    </form>
</div>

<?php include 'layouts/footer.php'; ?>