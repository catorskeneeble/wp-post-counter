<?php
	require_once "mpc-functions.php";
?>

<h1>Post Counter</h1>

<form action="" method="post">
	<div class="lol-q">
		<?php wp_dropdown_users(); ?>
	</div>

	<div class="lol-q">
		<select class="period" name="period">
			<option value="mpc_get_posts_today">Today's Posts</option>
			<option value="mpc_get_posts_yesterday">Yesterday's Posts</option>
			<option value="mpc_get_posts_last_7_days">Posts From Last 7 Days</option>
			<option value="mpc_get_posts_last_30_days">Posts From Last 30 Days</option>
			<option value="mpc_get_posts_last_week">Posts From Last Week</option>
			<option value="mpc_get_posts_current_month">Posts From Current Month</option>
			<option value="mpc_get_posts_last_month">Posts From Last Month</option>
			<option value="mpc_get_posts_custom_date_range">Posts From Custom Date Range</option>
		</select>
	</div>

	<div class="lol-q startdate">
		<label>Start Date</label>
		<input id="startdate" name="startdate" class="datepicker" />
	</div>
	<div class="lol-q enddate">
		<label>End Date</label>
		<input id="enddate" name="enddate" class="datepicker" />
	</div>

	<div class="lol-q">
		<input type="submit">
	</div>
</form>

<?php

if( isset($_POST['period']) && isset($_POST['user']) ) {
	$user = $_POST['user'];
	$period = $_POST['period'];

	if($period == 'mpc_get_posts_custom_date_range' && isset($_POST['startdate']) && isset($_POST['enddate'])) {
		$startdate = $_POST['startdate'];
		$enddate = $_POST['enddate'];	

		mpc_get_posts($period, $user, $startdate, $enddate);
	} else {
		mpc_get_posts($period, $user);
	}

	

}

?>

<script>
	jQuery(document).ready(function(){
		jQuery('.datepicker').datepicker();	
	});
</script>