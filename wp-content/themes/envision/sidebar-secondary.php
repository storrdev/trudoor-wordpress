<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

$sidebar_position = cloudfw( 'get', 'sidebar-position' ); 
$hide_sidebar_on_phones = cloudfw_check_onoff( 'global', 'hide_sidebar_on_phones' );
$class = '';

if ( $hide_sidebar_on_phones ) {
	$class = 'hidden-phone';
}

if ( $sidebar_position == 'dual' ) {

$custom_sidebar_secondary = cloudfw( 'get_sidebar_secondary_id' );

if ( is_active_sidebar( $custom_sidebar_secondary ) || cloudfw_custom_sidebar_exists( $custom_sidebar_secondary ) ): ?>

	<aside id="secondary-sidebars" class="sidebar-area widget-area secondary-sidebars <?php echo $class; ?> custom-widget-<?php echo $custom_sidebar_secondary;?>">
			<?php dynamic_sidebar( $custom_sidebar_secondary ); ?>
	<div id="sidebar-shadow"><div id="sidebar-shadow-top"></div><div id="sidebar-shadow-bottom"></div></div>
	</aside><!-- #custom(<?php echo $custom_sidebar_secondary;?>) .widget-area -->

<?php else:  
	if (is_search()) {$get_sidebar = 'searchpage-widget-area';}
	elseif (is_category()) {$get_sidebar = 'archive-widget-area';}
	elseif (is_archive()) {$get_sidebar = 'archive-widget-area';}
	elseif (is_page()) {$get_sidebar = 'default-widget-area';}
	else {$get_sidebar = 'blog-widget-area';}
?>
	<aside id="secondary-sidebars" class="sidebar-area widget-area secondary-sidebars <?php echo $class; ?>">
	<?php if ( ! dynamic_sidebar( $get_sidebar ) ) : ?>
			<?php cloudfw( 'default_sidebar', $get_sidebar );?>
    <?php endif;?>
	<div id="sidebar-shadow"><div id="sidebar-shadow-top"></div><div id="sidebar-shadow-bottom"></div></div>
	</aside>	
<?php endif; 

}