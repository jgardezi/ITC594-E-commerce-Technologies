<?php require_once("../core/includes/initialize.php"); ?>
<?php

if (isset($_POST['submitreply'])) {
    $body = mysql_real_escape_string($_POST['reply-content']);
    $topicid = mysql_real_escape_string($_POST['topicid']);
    $userid = mysql_real_escape_string($session->user_id);

    if (empty($body)):
        $message = 'Reply is empty. Please fill the comment.';
    else:
        $post = new Post();
        $post->post_content = trim($body);
        $post->post_date = date("Y-m-d G:i:s");;
        $post->post_topic = trim($topicid);
        $post->post_by = trim($userid);
        if ($post->create() ):
            $message = 'Succesfully posted your reply!';
        else:
            $message = "Something went wrong while posting. Please try again later.";
        endif;
    endif;
}

//echo "Session: " . $session->is_logged_in() . "<br />";

if (isset($_GET['id'])):
    $topic_id = mysql_real_escape_string($_GET['id']);

    $topic = new Topic();
    $topics = $topic->find_by_id($topic_id);

    $user_obj = new User();
    $user_topic = $user_obj->find_by_id($topics->topic_by);

    $sql = "select * 
            FROM posts
            where post_topic={$topic_id}
            ORDER BY post_date DESC";

    $postObj = new Post();
    $posts = $postObj->find_by_sql($sql);

    echo "<pre>";
    //print_r($category);
    //print_r($topics);
    //print_r($posts);
    echo "</pre>";
    ?>

    <?php include 'layouts/header.php'; ?>
    <?php include 'layouts/nav.php'; ?>
    <?php if ($session->is_logged_in()): ?>
        <?php

//echo $session->is_logged_in();
        if (empty($topics)) :
            echo 'The topic could not be displayed, please try again later.';
        else :
            echo '<h2>' . $topics->topic_name . '</h2>';
            echo '<p>Post by ' . $user_topic->first_name . ' ' . $user_topic->last_name . ' on ' . date('d-m-Y H:i', strtotime($topics->topic_date)) . '</p>';
            echo '<p>';
            echo $topics->topic_subject;
            echo '</p>';
        endif;

        echo "<br><hr><br>";

        foreach ($posts as $post => $value):
            echo '<div class="topic-post">
		<p class="user-post"><b>Reply by <U><I>' . $user_obj->find_by_id($value->post_by)->first_name . ' ' . $user_obj->find_by_id($value->post_by)->last_name . '</I></U> on <U><I>' . date('d-m-Y H:i', strtotime($value->post_date)) . '</I></U></b></p>
		<p class="post-content">' . htmlentities(stripslashes($value->post_content)) . '</p>
              </div>';
        endforeach;
        echo "<hr><br>";

        if (isset($message)):
            echo "<p>$message</p>";
        endif;
        echo '<div>
            <h2>Reply:</h2>
            <form method="post" action="topic.php?id=' . $topic_id . '">
                <textarea placeholder="Write your reply here..." name="reply-content" required></textarea><br /><br />
                <input type="hidden" name="topicid" value="' . $topic_id . '" />
                <input type="submit" name="submitreply" value="Submit Reply" />
            </form>
          </div>';
        ?>
        <?php

    else:
        echo '<p>You must be <a href="signin.php">signed in</a> to view the topic. You can also <a href="signup.php">sign up</a> for an account.</p>';
    endif;
    ?>
    <?php include 'layouts/footer.php'; ?>
<?php endif; ?>