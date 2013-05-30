<?php
/*
Plugin Name: Duplicate Posts Eraser
Plugin URI: http://www.theblackmelvyn.com/2009/02/supprimer-doublons-autoblogs-wordpress-plugin/
Description: Deletes duplicate posts based on their title
Author: BlackMelvyn
Version: 1.1
Author URI: http://www.theblackmelvyn.com/
*/
function clearDuplicatePosts(){
	global $wpdb;
	$prefix = $wpdb->prefix;
	
	$wpdb->query("DELETE bad_rows . * FROM ".$prefix."posts AS bad_rows INNER JOIN (
		SELECT ".$prefix."posts.post_title, MIN( ".$prefix."posts.ID ) AS min_id
		FROM ".$prefix."posts
		GROUP BY post_title
		HAVING COUNT( * ) >1
		) AS good_rows ON ( good_rows.post_title = bad_rows.post_title
		AND good_rows.min_id <> bad_rows.ID )");
}
add_action('publish_post', 'clearDuplicatePosts');

?>