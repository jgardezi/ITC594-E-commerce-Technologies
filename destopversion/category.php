<?php require_once("../core/includes/initialize.php"); ?>
<?php

//echo "Session: " . $session->is_logged_in() . "<br />";

if (isset($_GET['id']))
    $category_id = mysql_escape_string($_GET['id']);

$categories = new Category();
$category = $categories->find_by_id($category_id);

$topic = new Topic();
$topics = $topic->find_by_cat_id($category_id);
echo "<pre>";
//print_r($category);
//print_r($topics);
echo "</pre>";
?>

<?php include 'layouts/header.php'; ?>
<?php include 'layouts/nav.php'; ?>
<?php

if (empty($topics)) :
    echo 'There are no topics in this category yet.';
else :
    echo '<h2>Topics in &prime;' . $category->cat_name . '&prime; category</h2><br />';
    echo '<table border="1">
	  <tr>
            <th>Topic</th>
            <th>Created at</th>
	  </tr>';

    foreach ($topics as $topic => $value):
        //print_r($category);
        echo "<tr>";
            echo '<td class="leftpart">';
                echo '<h3><a href="topic.php?id=' . $value->topic_id . '">' . $value->topic_name . '</a></h3>';
            echo '</td>';
            echo '<td class="rightpart">';
                echo date('d-m-Y', strtotime($value->topic_date));
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
