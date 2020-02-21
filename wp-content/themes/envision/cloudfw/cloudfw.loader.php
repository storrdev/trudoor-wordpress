<?php
/**
 *	CloudFw - WordPress Theme Framework
 *	
 * 	@author 	Orkun Gursel
 *	@package 	WordPress
 *	@subpackage CloudFw
 */
define( 'CLOUDFW_PATH',  TMP_PATH.'/cloudfw' );

/**
 *	Load text domain.
 */
function cloudfw_load_textdomain() {
	load_theme_textdomain( 'cloudfw', TMP_PATH.'/languages' );
	load_child_theme_textdomain( 'cloudfw', get_stylesheet_directory() . '/languages' );
}

/** Load Cache Mechanism */
include(CLOUDFW_PATH.'/core/engine.cache/core.var_cache.php');

$is_admin = is_admin();

/** Activate Revisions */
if ( $is_admin ) {
	if ( ! defined( 'WP_POST_REVISIONS' ) ) {
		define( 'WP_POST_REVISIONS' , false);
	}

}

if( function_exists('set_revslider_as_theme') ) {
	set_revslider_as_theme();
}

/** Customization Functions for Core Framework */
if (file_exists( TMP_PATH.'/customization.core.php'))
	include(TMP_PATH.'/customization.core.php');

/** Set Globals */
global $_opt;

/** Load Core Configs */
require( CLOUDFW_PATH.'/core/framework/core.configs.php' );

/** Load Language Files From "languages/" folder */
cloudfw_load_textdomain();

/** Check Compabilities */
require( CLOUDFW_PATH.'/core/framework/cloudfw.check.php' );

if ( ! get_option(PFIX . '_already_installed') ) {
    define('CLOUDFW_INSTALLING', TRUE);
}

/** Load Map Engine */
require( CLOUDFW_PATH.'/core/engine.map/core.map.php' );

/** Customization Functions to Init */
if (file_exists( TMP_PATH.'/customization.init.php'))
	include(TMP_PATH.'/customization.init.php');

/* Load the Theme Source Codes */
do_action( 'cloudfw_requires' );
require( TMP_LOADERS.'/theme.maps.php' );

/* Load CloudFw */
require( CLOUDFW_PATH.'/core/framework/core.elements.php' );
require( CLOUDFW_PATH.'/core/framework/core.functions.php' );
require( CLOUDFW_PATH.'/core/framework/core.translate.php' );

if ( $is_admin ) {
	require( CLOUDFW_PATH.'/core/framework/core.only_admin.php' );

	if ( file_exists( CLOUDFW_PATH.'/core/classes/class.tgm-plugin-activation.php' ) ) {
		require( CLOUDFW_PATH.'/core/classes/class.tgm-plugin-activation.php' );
		if ( file_exists( TMP_LOADERS.'/theme.plugins.php' ) )
			require( TMP_LOADERS.'/theme.plugins.php' );
	}
	
}

require( CLOUDFW_PATH.'/core/engine.shortcode/core.shortcodes.php' ); $CloudFw_Shortcodes = new CloudFw_Shortcodes();

/** Load Modules */
require( CLOUDFW_PATH.'/core/engine.modules/core.modules.php' );
require( CLOUDFW_PATH.'/core/engine.widget/core.widgets.php' );
cloudfw_autoload_folders( TMP_MODULES, TRUE );
do_action('cloudfw_modules_load');

/** Register Modules */
do_action('cloudfw_modules_init');

require( CLOUDFW_PATH.'/core/engine.typo/core.typo.php' );
require( CLOUDFW_PATH.'/core/engine.skin/core.skin_engine.php' );
require( CLOUDFW_PATH.'/core/engine.slider/core.slider.php' );
require( CLOUDFW_PATH.'/core/engine.composer/core.composer.frontend.php' );

/* Get All Options */
$_opt = cloudfw_get_all_options();

if ( $is_admin && file_exists( TMP_LOADERS . '/theme.schemes.menu.php' ) )
	require( CLOUDFW_PATH.'/core/engine.menu/core.menu.php' );

/* WPML Functions */
if 	( cloudfw_ml_plugin() == 'wpml' ){
	require( CLOUDFW_PATH.'/core/framework/core.wpml.php' );
	require( TMP_LOADERS.'/theme.wpml.php' );
	do_action( 'cloudfw_wpml_register' );
}

require( TMP_LOADERS.'/theme.sidebars.php' );

/* Run CloudFw */
require( TMP_LOADERS.'/theme.setup.php' );
require( TMP_LOADERS.'/theme.init.php' );

/* Load The Theme */
require( TMP_LOADERS.'/theme.functions.php' );

/** Load Base Page Generator */
require( CLOUDFW_PATH.'/core/engine.page_generator/core.page_generator.php' );
/** Load theme Pages */
if ( file_exists(TMP_LOADERS.'/theme.page_generator.php') )
    require( TMP_LOADERS.'/theme.page_generator.php' );

/** Run Modules */
do_action('cloudfw_modules');

/** Load Shortcodes */
cloudfw_autoload_folders( TMP_SHORTCODES );
cloudfw_load_shortcodes();

if ( $is_admin ) {
	require( CLOUDFW_PATH.'/core/framework/core.save.php' );
}

require( CLOUDFW_PATH.'/core/framework/core.init.php' );
/* Only Admin Area */
if ( $is_admin ) {
	require( CLOUDFW_PATH.'/core/framework/core.admin_init.php' );
}

/** Load Widgets */
cloudfw_autoload_folders( TMP_WIDGETS );

if ( $is_admin ) {
	require( TMP_LOADERS.'/theme.quicktags.php' );
	require( TMP_LOADERS.'/theme.metaboxes.php' );
	require( CLOUDFW_PATH.'/core/engine.metabox/core.metabox.php' );
	require( CLOUDFW_PATH.'/core/engine.composer/core.composer.php' );
}

/** Ajax Functions */
if( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
	require( TMP_LOADERS.'/theme.ajax.php' );
	
	if ( $is_admin ) {
		require( CLOUDFW_PATH.'/core/ajax/core.ajax.php' );
	}
}

/** Custom Menu Functions */
if (function_exists('cloudfw_megamenu_admin_init'))
	add_action( 'after_setup_theme', 'cloudfw_megamenu_admin_init');

/** Customization */
if (file_exists( TMP_PATH.'/customization.php'))
	include( TMP_PATH.'/customization.php' );

do_action('cloudfw_loaded');