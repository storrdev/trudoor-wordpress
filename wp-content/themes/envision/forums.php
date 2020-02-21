<?php
/**
 *	BBPress Page Layout
 *
 *	@since 1.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

$cloudfw = cloudfw();
$layout = $cloudfw->page_settings(
	'bbpress', 
	array(
		'layout' 		 => 'layout',
		'sidebar' 		 => 'sidebar',
		'titlebar_style' => 'titlebar_style',
		'skin' 			 => 'skin',
		'_defaults'      => array(
			'sidebar'      => 'default-widget-area',
		),
	), 
	'layout'
);


$cloudfw->set_meta( 'titlebar_title', __('Forum','cloudfw') );

if ( bbp_is_single_forum() ) {
	$cloudfw->set_meta( 'titlebar_title', bbp_get_forum_title() );
	$cloudfw->set_meta( 'titlebar_text', bbp_get_forum_content() );
} elseif ( bbp_is_single_topic() ) {
	$cloudfw->set_meta( 'titlebar_title', bbp_get_topic_title() );
}

$cloudfw->set( 'skip_is_blog', true );

/** Check is topic page */
if ( function_exists('bbp_is_topic') && bbp_is_topic( $cloudfw->get_ID() ) ) {

	$layout = $cloudfw->page_settings(
		'bbpress', 
		array(
			'layout' 		 => 'single_layout',
			'sidebar' 		 => 'single_sidebar',
			'titlebar_style' => 'single_titlebar_style',
			'skin' 			 => 'single_skin',
		), 
		'layout'
	);

}


if ( !empty($layout) ) {
	$cloudfw->return_layout( $layout );
}

$cloudfw->check('type');
get_header(); ?>

	<?php cloudfw( 'page' ); ?>

<?php get_footer(); ?>