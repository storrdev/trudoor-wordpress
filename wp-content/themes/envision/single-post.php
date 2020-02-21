<?php
/**
 *	Single Blog Page
 *
 *	@since 1.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

$that   = cloudfw();
$sidebar = cloudfw_get_option( 'blog_single', 'sidebar' );
$titlebar_style = cloudfw_get_option( 'blog_single', 'titlebar_style' );

$skin = cloudfw_get_option( 'blog_single', 'skin' );
$post_skin = $that->get_meta( 'custom_skin' );
if ( empty( $post_skin ) ) {
	$that->set_meta( 'custom_skin', $skin );
}

if ( ! $layout = $that->get_layout() ) {
	$layout = cloudfw_get_option( 'blog_single', 'layout' );
}

if ( !empty($sidebar) ) {
	$that->set('custom_sidebar', $sidebar);
}

if ( !empty($titlebar_style) ) {
	$that->set('default_titlebar_style', $titlebar_style);
}

if ( empty($layout) ) {
	$layout = $that->blog_page_layout();
}

if ( empty($layout) ) {
	$layout = 'index.php';
}

$that->return_layout( $layout );