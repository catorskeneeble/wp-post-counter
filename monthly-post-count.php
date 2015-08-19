<?php

/*
Plugin Name: Monthly Post Reporter
PluginURI:   http://koreanhln.com
Description: This plugin provides an administrator
             with a user interface for counting posts
             by month.
Version:     1.0
Author:      Pak
*/

if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'admin_menu', 'monthly_post_count_admin_menu');

function monthly_post_count_admin_menu() {
	add_menu_page(
		'Monthly Post Count', // 1
		'Monthly Post Count', // 2
		'delete_others_posts', // 3
		'mpc-page.php', // 4
		'mpc_page' // 5
	);
}

function mpc_page()
{
	wp_enqueue_style('derp', plugin_dir_url(__FILE__) .'style.css');
	wp_enqueue_style('jquery-ui-css', 'https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.css');
	wp_enqueue_script( 'jquery-ui', 'https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.js' );
	include 'mpc-page.php';
}


