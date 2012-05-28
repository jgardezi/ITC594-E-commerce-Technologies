<?php require_once("../core/includes/initialize.php"); ?>
<?php
if (!$session->is_logged_in()) {
    redirect_to("index.php");
}

// Remember to give your form's submit tag a name="submit" attribute!
if (isset($_POST['submittopic'])) { // Form has been submitted.
    $top_name = trim($_POST['topic_name']);
    $cat_id = trim($_POST['cat_id']);
    $topic_desc = trim($_POST['topic_desc']);
    $userid = trim($_SESSION['user_id']);
    
    if(!empty($top_name)):
        $topic = new Topic();
        $topic->topic_name = $top_name;
        $topic->topic_subject = $topic_desc;
        $topic->topic_cat = $cat_id;
        $topic->topic_by = $userid;
        $topic->topic_date = date("Y-m-d G:i:s");
        
        if ($topic->create()):
            $message = "New Topic succesfully added.";
        else:
            $message = "Error while creating new topic.";
        endif;
    else:
        $message = "Topic name can't be empty. Please fill this field.";
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
        if(isset($_SESSION['userlevel']) ):
    ?>
    <h2>Create a topic</h2>
    <form id="signupforum" method="post" action="">
        <label for="cat_name">Topic name: </label>
        <input class="inputText" type="text" name="topic_name" autofocus required /><br />
        <?php 
            $category = new Category(); 
            $categories = $category->find_all();
        ?>
        <label for="cat">Category: </label>
        <select name="cat_id">
            <?php foreach ($categories as $cat ): ?>
                <option value="<?php echo $cat->cat_id; ?>"><?php echo $cat->cat_name; ?></option>
            <?php endforeach; ?>
        </select> 
        
        <br /><br />
        <label for="topic_desc">Topic description: </label>
        <textarea name="topic_desc" id="topic_desc" class="inputTA" tabindex="70" cols="45" rows="10"></textarea><br />

        <input type="submit" name="submittopic" value="Create Topic" />
    </form>
    <?php 
        else:
            echo '<p>Only registered users can create a topic. Please signup <a href="signin.php">sign in</a> and start posting!</p>';
        endif;
    ?>
</div>

<?php include 'layouts/footer.php'; ?>