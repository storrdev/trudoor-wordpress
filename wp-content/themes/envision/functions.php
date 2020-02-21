<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 *	Envision Multipurpose Theme (2013) - ThemeForest
 *	functions.php which does and tells WordPress to load CloudFW and the theme.
 *
 * 				(Ya-Settar, Ya-Gaffar, Ya-Fettâh)
 * 	@author 	Orkun GURSEL
 *				<ticket:	support.cloudfw.net>
 *				<email:		support@cloudfw.net>
 *				<twitter: 	@orkungursel, @cloudfw>
 *
 *	@package 	WordPress
 *	@subpackage	CloudFw
 *	@subpackage	Envision
 */
/** Globals */

global $cloudfw_start, $cloudfw_memory;
$time = microtime();
$time = explode(" ", $time);
$time = $time[1] + $time[0];
$cloudfw_start = $time;
$cloudfw_memory = memory_get_usage();

/** Defines */
if ( !defined('TMP_PATH') ) 		define( 'TMP_PATH', get_template_directory() . '/' );
if ( !defined('TMP_URL') ) 			define( 'TMP_URL', get_template_directory_uri() );
if ( !defined('CLOUDFW_TMP_PATH') )	define( 'CLOUDFW_TMP_PATH', dirname(__FILE__) );

/**
 *	Load & Run CloudFw
 */
require( TMP_PATH.'/cloudfw/cloudfw.loader.php' );


Function clean_header(){
	wp_deregister_script( 'comment-reply' );
}
add_action('init','clean_header');

// function yst_ssl_template_redirect() {
// 	if ( is_page( 4579 ) && ! is_ssl() ) {
// 		if ( 0 === strpos($_SERVER['REQUEST_URI'], 'http') ) {
// 			wp_redirect(preg_replace('|^http://|', 'https://', $_SERVER['REQUEST_URI']), 301 );
// 			exit();
// 		} else {
// 			wp_redirect('https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'], 301 );
// 			exit();
// 		}
// 	} else if ( !is_page( 4579 ) && is_ssl() && !is_admin() ) {
// 		if ( 0 === strpos($_SERVER['REQUEST_URI'], 'http') ) {
// 			wp_redirect(preg_replace('|^https://|', 'http://', $_SERVER['REQUEST_URI']), 301 );
// 			exit();
// 		} else {
// 			wp_redirect('http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'], 301 );
// 			exit();
// 		}
// 	}
// }
// add_action( 'template_redirect', 'yst_ssl_template_redirect', 1 );

remove_action  ('admin_print_scripts', 'cloudfw_module_enqueue_icomoon', 2);
remove_action  ('wp_print_styles', 'cloudfw_module_enqueue_icomoon', 2);

/******* Customize Login Logo ******/
function my_custom_login_logo() {
    echo '<style type="text/css">
       #login h1 a { background-image:url('.get_bloginfo('stylesheet_directory').'/login_logo.png) !important; background-size: 312px 100px !important; height: 100px !important; width: 300px !important; }
    </style>';
}
add_action('login_head', 'my_custom_login_logo');

remove_action( 'wp_head', 'rsd_link' );
remove_action( 'wp_head', 'wlwmanifest_link' );
remove_action( 'wp_head', 'wp_shortlink_wp_head' );
remove_action( 'template_redirect', 'wp_shortlink_header', 11 );
remove_action( 'wp_head', 'feed_links', 2 );
remove_action( 'wp_head', 'feed_links_extra', 3 );




