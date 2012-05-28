<div id="menu">
    <a class="item" href="index.php">Home</a> - 
    <?php if($session->is_logged_in()): ?>
        <a class="item" href="create_topic.php">Create a topic</a> - 
        <a class="item" href="create_cat.php">Create a category</a>
    <?php endif;?>

    <div id="userbar">
        <?php
        if ($session->is_logged_in())
            echo 'Hello <b>' . $_SESSION['username'] . '</b>. Not you? <a class="item" href="signout.php">Sign out</a>';
        else
            echo '<a class="item" href="signin.php">Sign in</a> or <a class="item" href="signup.php">create an account</a>';
        ?>
    </div>
</div>