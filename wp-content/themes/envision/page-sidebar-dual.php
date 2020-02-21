<?php
/**
 *	Template Name: Sidebar - Dual
 *
 *	@since 1.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

cloudfw( 'set', 'layout', basename(__FILE__) );
cloudfw( 'set', 'sidebar', true );
cloudfw( 'set', 'sidebar-position', 'dual' );
cloudfw( 'check', 'type' );
cloudfw( 'check', 'is_blog' );

get_header(); ?>

	<?php cloudfw( 'page', 'sidebar' ); ?>

<?php get_footer(); ?>