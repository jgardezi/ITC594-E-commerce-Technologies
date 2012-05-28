<?php
// If it's going to need the database, then it's
// probably smart to require it before we start.
require_once (LIB_PATH . DS . 'database.php');

class Post extends DatabaseObject {
	
	protected static $table_name = "posts";
	protected static $db_fields = array ('post_id', 'post_content', 'post_date', 'post_topic', 'post_by' );
	
	public $post_id;
	public $post_content;
	public $post_date;
	public $post_topic;
	public $post_by;
	
}