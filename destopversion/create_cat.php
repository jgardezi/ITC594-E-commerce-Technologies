<?php require_once("../core/includes/initialize.php"); ?>
<?php
if (!$session->is_logged_in()) {
    redirect_to("index.php");
}

// Remember to give your form's submit tag a name="submit" attribute!
if (isset($_POST['submit'])) { // Form has been submitted.
    $cat_name = trim($_POST['cat_name']);
    $cat_desc = trim($_POST['cat_desc']);

    if(!empty($cat_name)):
        $cat = new Category();
        $cat->cat_name = $cat_name;
        $cat->cat_description = $cat_desc;
        if ($cat->create()):
            $message = "New category succesfully added.";
        else:
            $message = "Error while creating new category.";
        endif;
    else:
        $message = "Category name can't be empty. Please fill this field.";
    endif;
} 
?>

<?php include 'layouts/header.php'; ?>
<?php include 'layouts/nav.php'; ?>

<div id="signup">
    <?php
    if (isset($message))
        echo $message;
    ?>
    <?php 
        if(isset($_SESSION['userlevel']) && $_SESSION['userlevel'] == 1):
    ?>
    <h2>Create a category</h2>
    <form id="signupforum" method="post" action="">
        <label for="cat_name">Category name: </label>
        <input class="inputText" type="text" name="cat_name" autofocus required /><br />

        <label for="cat_desc">Category description: </label>
        <textarea name="cat_desc" id="cat_desc" tabindex="70" cols="45" rows="10"></textarea><br />

        <input type="submit" name="submit" value="Create Category" />
    </form>
    <?php 
        else:
            echo "<p>Sorry, you do not have sufficient rights to access this page.</p>";
        endif;
    ?>
</div>

<?php include 'layouts/footer.php'; ?>