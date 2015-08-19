<?php

function mpc_get_posts ($op, $user, $start = '', $end = '') {

	switch ($op) {
		case "mpc_get_posts_today":
			$post_rows = mpc_get_posts_today($user);
			break;
		case "mpc_get_posts_yesterday":
			$post_rows = mpc_get_posts_yesterday($user);
			break;
		case "mpc_get_posts_last_7_days":
			$post_rows = mpc_get_posts_last_7_days($user);
			break;
		case "mpc_get_posts_last_30_days":
			$post_rows = mpc_get_posts_last_30_days($user);
			break;
		case "mpc_get_posts_last_week":
			$post_rows = mpc_get_posts_last_week($user);
			break;
		case "mpc_get_posts_current_month":
			$post_rows = mpc_get_posts_current_month($user);
			break;
		case "mpc_get_posts_last_month":
			$post_rows = mpc_get_posts_last_month($user);
			break;
		case "mpc_get_posts_custom_date_range":
			$post_rows = mpc_get_posts_custom_date_range($user, $start, $end);
			break;
	}
	
	print_posts($post_rows);

}


function mpc_get_posts_today ($user) {

	$args = array(
		'author' => $user,
		'post_status' => 'publish',
		'posts_per_page' => -1
	);	

	function filter_where($where = '') {
		$where .= " AND post_date >= '" . date('Y-m-d', strtotime('today')) . "'";
		return $where;
	}

	add_filter('posts_where', 'filter_where');
	$post_container = query_posts($args);
	remove_filter('posts_where', 'filter_where');
	return $post_container;
}


function mpc_get_posts_yesterday ($user) {
	
	$args = array(
		'author' => $user,
		'post_status' => 'publish',
		'posts_per_page' => -1
	);	

	function filter_where($where = '') {
		$where .= " AND post_date >= '" . date('Y-m-d', strtotime('-1 days')) . "'" . " AND post_date < '" . date('Y-m-d', strtotime('today')) . "'";
    	return $where;
	}

	add_filter('posts_where', 'filter_where');
	$post_container = query_posts($args);
	remove_filter('posts_where', 'filter_where');
	return $post_container;
}


function mpc_get_posts_last_7_days ($user) {
	
	$args = array(
		'author' => $user,
		'post_status' => 'publish',
		'posts_per_page' => -1
	);	

	function filter_where($where = '') {
		$where .= " AND post_date > '" . date('Y-m-d', strtotime('-7 days')) . "'";
		return $where;
	}

	add_filter('posts_where', 'filter_where');
	$post_container = query_posts($args);
	remove_filter('posts_where', 'filter_where');
	return $post_container;
}


function mpc_get_posts_last_30_days ($user) {
	
	$args = array(
		'author' => $user,
		'post_status' => 'publish',
		'posts_per_page' => -1
	);

	function filter_where($where = '') {
		$where .= " AND post_date > '" . date('Y-m-d', strtotime('-30 days')) . "'";
		return $where;
	}
	add_filter('posts_where', 'filter_where');
	$post_container = query_posts($args);
	remove_filter('posts_where', 'filter_where');
	return $post_container;
}


function mpc_get_posts_last_week ($user) {
	
	$args = array(
		'author' => $user,
		'post_status' => 'publish',
		'posts_per_page' => -1
	);	

	function filter_where($where = '') {
		$where .= " AND post_date >= '" . date('Y-m-d', strtotime('previous week -1 days')) . "'" . " AND post_date < '" . date('Y-m-d', strtotime('previous week +5 days')) . "'";
    	return $where;
	}

	add_filter('posts_where', 'filter_where');
	$post_container = query_posts($args);
	remove_filter('posts_where', 'filter_where');
	return $post_container;
}


function mpc_get_posts_current_month ($user) {
	
	$args = array(
		'author' => $user,
		'post_status' => 'publish',
		'posts_per_page' => -1
	);	

	function filter_where($where = '') {
		$where .= " AND post_date >= '" . date('Y-m-01', strtotime('now')) . "'" . " AND post_date <= '" . date('Y-m-t', strtotime('now')) . "'";
    	return $where;
	}

	add_filter('posts_where', 'filter_where');
	$post_container = query_posts($args);
	remove_filter('posts_where', 'filter_where');
	return $post_container;	
}


function mpc_get_posts_last_month ($user) {
	
	$args = array(
		'author' => $user,
		'post_status' => 'publish',
		'posts_per_page' => -1
	);	

	function filter_where($where = '') {
		$where .= " AND post_date >= '" . date('Y-m-01', strtotime('last month')) . "'" . " AND post_date <= '" . date('Y-m-t', strtotime('last month')) . "'";
    	return $where;
	}

	add_filter('posts_where', 'filter_where');
	$post_container = query_posts($args);
	remove_filter('posts_where', 'filter_where');
	return $post_container;	
}


function mpc_get_posts_custom_date_range ($user, $start, $end) {

	$start = date('Y-m-d', strtotime($start));
	$end = date('Y-m-d', strtotime($end));

	$args = array(
		'author' => $user,
		'post_status' => 'publish',
		'post_type' => 'post',
		'posts_per_page' => -1,
		'date_query' => array ( 'after' => $start, 'before' => $end )
	);	

	$post_container = new WP_Query($args);

	return $post_container->posts;
}


function print_posts ($post_data) {

	$num_posts = sizeof($post_data);

	echo "<br><h2>Post Count: $num_posts</h2>";

	echo "<table><thead><tr><td>Post Date</td><td>Post Title</td></tr></thead><tbody>\n";

	for($i = 0; $i < sizeof($post_data); $i++) {
		$current_post = $post_data[$i];

		echo "<tr><td>$current_post->post_date</td><td><a href='$current_post->guid'>$current_post->post_title</a></td></tr>\n";
	}

	echo "</tbody></table>";

}


