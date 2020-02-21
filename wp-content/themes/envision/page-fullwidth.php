<?php
/**
 *	Template Name: Fullwidth Page
 *
 *	@since 1.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

cloudfw( 'set', 'layout', basename(__FILE__) );
cloudfw( 'set', 'sidebar', false );
cloudfw( 'set', 'sidebar-position', '' );
cloudfw( 'check', 'type' );
cloudfw( 'check', 'is_blog' );
get_header(); ?>

	<?php cloudfw( 'page' ); ?>

<?php get_footer(); ?>