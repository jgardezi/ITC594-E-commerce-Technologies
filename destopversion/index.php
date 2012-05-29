<?php require_once("../core/includes/initialize.php"); ?>
<?php

//echo "Session: " . $session->is_logged_in() . "<br />";

$cat = new Category();
$categories = $cat->find_all();
?>

<?php include 'layouts/header.php'; ?>
<?php include 'layouts/nav.php'; ?>
<?php

if (empty($categories)) :
    echo 'No categories defined yet.';
else :
    echo '<table border="1">
	  <tr>
            <th>Category</th>
            <th>Last topic</th>
	  </tr>';
    foreach($categories as $category => $value):
        //print_r($category);
        echo "<tr>";
            echo '<td class="leftpart">';
                echo '<h3><a href="category.php?id=' . $value->cat_id . '">' . $value->cat_name . '</a></h3>' . $value->cat_description;
            echo '</td>';
            $sql = "SELECT
                        t.topic_id,
                        t.topic_name,
                        t.topic_date,
                        t.topic_cat
                    from topics AS t
                    where t.topic_cat = {$value->cat_id}
                        ORDER BY t.topic_id DESC
                        LIMIT 1";
                    $topic = new Topic();
                    $topics = $topic->find_by_sql($sql);
                echo '<td class="rightpart">';
                    if( !empty($topics) ):
                        echo '<a href="topic.php?id=' . $topics[0]->topic_id . '">' . $topics[0]->topic_name . '</a> at ' . date('d-m-Y', strtotime($topics[0]->topic_date));
                    else:
                        echo 'no topics';
                    endif;
                echo '</td>';
            
        echo "</tr>";
    endforeach;
    echo '</table>';
endif;

echo "<br><br><pre>";
//print_r($_SESSION);
echo "</pre>";
?>

<?php include 'layouts/footer.php'; ?>
