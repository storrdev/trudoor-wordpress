<?php

add_theme_support( 'responsive' );
add_theme_support( 'retina' );
add_theme_support( 'woocommerce' );
add_theme_support( 'W3C_compatibility' );

/**
 *  Setup Function
 *
 *  @since 1.0
 */
do_action('cloudfw_theme_init');

add_action( 'after_setup_theme', 'cloudfw_setup_init' );

if ( ! function_exists( 'cloudfw_setup_init' ) ) {
	function cloudfw_setup_init() {

		/** Add support for feed links to be able to be created automaticaly */
		add_theme_support( 'automatic-feed-links' );

		/** Add support for a variety of post formats */
		add_theme_support( 'post-formats', array( 'image', 'video', 'gallery', 'link', 'quote' ) );


		/** Add support for post thumbnails */
		add_theme_support( 'post-thumbnails' );

		$cloudfw_post_thumbnails = apply_filters( 'cloudfw_post_thumbnails' , array( 'post' ));
		if ( is_array($cloudfw_post_thumbnails) && !empty($cloudfw_post_thumbnails) ) {
			foreach ( $cloudfw_post_thumbnails as $post_type ) {
				add_post_type_support( $post_type, 'thumbnail' );
			}
		}

		//add_theme_support( 'cufon' );

		/** Register Navigation Menus */
		register_nav_menus( array(
				'primary'   => __( 'Navigation Menu', 'cloudfw' ),
				'footer'    => __( 'Footer Menu', 'cloudfw' ),
				'topbar'    => __( 'Top Bar Menu', 'cloudfw' ),
			)
		);
	}
}

function cloudfw_set_js_options(){
	cloudfw_set_js('themeurl', TMP_URL );
	cloudfw_set_js('ajaxUrl', cloudfw_ajax_url() );
	cloudfw_set_js('device', 'widescreen' );
	cloudfw_set_js('RTL', is_rtl() );
	cloudfw_set_js('SSL', is_ssl() );
	cloudfw_set_js('protocol', is_ssl() ? 'https' : 'http' );
	cloudfw_set_js('responsive', cloudfw_is_responsive() );
	cloudfw_set_js('lang', cloudfw_get_current_language() );
	cloudfw_set_js('sticky_header', cloudfw_check_onoff( 'header', 'sticky' ) );
	cloudfw_set_js('header_overlapping', cloudfw_check_onoff('header', 'overlapping') );
	cloudfw_set_js('navigation_event', cloudfw_get_option('navigation', 'event', 'hover') );

	$sticky_offset = (int) cloudfw_get_option( 'header', 'sticky_offset' );

	if ( cloudfw_check_onoff( 'topbar', 'sticky' ) && $sticky_offset == 0 ) {
		$sticky_offset = 30;
	}

	cloudfw_set_js('sticky_header_offset', 0 - $sticky_offset );
	cloudfw_set_js('uniform_elements', cloudfw_check_onoff( 'global', 'uniform' ) );
	cloudfw_set_js('disable_prettyphoto_on_mobile', cloudfw_check_onoff( 'troubleshooting', 'disable_prettyphoto_on_mobile' ) );

	if ( class_exists('GFForms') ) {
		cloudfw_set_js('disable_gravity_uniform_select', cloudfw_check_onoff( 'troubleshooting', 'disable_gravity_uniform_select' ) );
	}
	cloudfw_set_js('text_close', cloudfw_translate('close') );
}

/**
 *    Add Skin Options
 *
 *    @since 1.0
 */
function cloudfw_add_skin_scheme( $location, $schemes, $scheme, $seq = 50){
	switch ( $location ) {
		case 'slider': $location = 80; break;
		case 'shortcode': $location = 81; break;
		case 'module': $location = 82; break;
		case 'widget': $location = 81; break;
		default: $location = 0; break;
	}

	if ( !$location ) {
		return cloudfw_error_message( 'Please set a location for the skin options.' );
	}


	$section = $schemes[$location]['data'];
	$schemes[$location]['data'][ cloudfw_id_for_sequence( $section, $seq ) ] = $scheme;
	return $schemes;
}

/**
 *    Add Module Options
 *
 *    @since 1.0
 */
function cloudfw_add_option_scheme( $location, $schemes, $scheme, $seq = 50 ){
	switch ( $location ) {
		case 'module':
			$schemes[35]['data'][ cloudfw_id_for_sequence( $schemes[35]['data'], $seq ) ] = $scheme;
			break;
		case 'translate':
			$schemes[36]['data'][ cloudfw_id_for_sequence( $schemes[36]['data'], $seq ) ] = $scheme;
			break;
	}
	return $schemes;
}

/**
 *  Cufon Defaults
 *
 *  @since 1.0
**/
add_filter( 'cloudfw_cufon_defaults', 'cloudfw_cufon_defaults' );
function cloudfw_cufon_defaults( $font ) {

	if ( !( current_theme_supports('cufon') && cloudfw_check_onoff('cufon', 'enable') ) ) {
		return;
	}

	if ( cloudfw_check_onoff('cufon', 'applytoNavigation' ) ) {
		$out[] = "Cufon.replace(\"nav ul > li > span > a\", {fontFamily : \"". _if( $fontTypeNavigation = cloudfw_cufon_get_fontfamily( cloudfw_cufon_path(cloudfw_get_option( 'cufon', 'fontTypeNavigation' ) ) ), $fontTypeNavigation, $font ) ."\", hover: true});";
	}

	if ( cloudfw_check_onoff('cufon', 'applytoHeadings' ) ) {
		$out[] = "Cufon.replace(\"h1, h2, h3, h4, h5, h6, .h1, .h2, .h3, .h4, .h5, .h6, .heading\", {fontFamily : \"". _if( $fontTypeHeadings = cloudfw_cufon_get_fontfamily( cloudfw_cufon_path(cloudfw_get_option( 'cufon', 'fontTypeHeadings' ) ) ), $fontTypeHeadings, $font ) ."\", hover: true});";
	}

	if ( cloudfw_check_onoff('cufon', 'applytoButtons' ) ) {
		$out[] = "Cufon.replace(\".btn\", {fontFamily : \"". _if( $fontTypeButtons = cloudfw_cufon_get_fontfamily( cloudfw_cufon_path(cloudfw_get_option( 'cufon', 'fontTypeButtons' ) ) ), $fontTypeButtons, $font ) ."\", hover: true});";
	}

	if ( cloudfw_check_onoff('cufon', 'applytoDropcaps' ) ) {
		$out[] = "Cufon.replace(\".dropcap\", {fontFamily : \"". _if( $fontTypeButtons = cloudfw_cufon_get_fontfamily( cloudfw_cufon_path(cloudfw_get_option( 'cufon', 'fontTypeDropcaps' ) ) ), $fontTypeButtons, $font ) ."\", hover: false});";
	}


	if( $out )
		$out = implode( "\n", $out );

	return $out;
}

/**
 *  Edit Global WP Query for Search Pages
 *
 *  @since 1.0
**/
//add_filter('pre_get_posts', 'cloudfw_filter_search');
function cloudfw_filter_search( $query ) {
	if($query->is_search)
		$query->set('post_type', array( 'post', 'page' ));
	return $query;
}

/**
 *  Exclude Selected Categories From Categories List
 *
 *  @since 1.0
**/
add_filter('pre_get_posts', 'cloudfw_exclude_blog_category');
function cloudfw_exclude_blog_category($query) {
	$page_for_posts = get_option("page_for_posts");

	if ( ! $page_for_posts )
		return $query;

	if ( isset($query ->queried_object_id) ):
		if ( $query ->queried_object_id == $page_for_posts ) {

			global $_opt;
			$exclude = isset($_opt[PFIX."_excluded_blog_categories"]) && $_opt[PFIX."_excluded_blog_categories"];

			$result = '';
			foreach ((array)$exclude as $ec) {
				$result .= ' -' . $ec;
			}
			$query->set('cat', $result);
		}
	endif;
	return $query;
}

/**
 *    CloudFw Body Classes
 *
 *    @since 1.0
 */
add_filter('body_class','cloudfw_body_classes');
function cloudfw_body_classes( $classes ) {
	$classes[] = 'run';

	if ( wp_is_mobile() ) {
		$classes[] = 'ui--mobile';
	}

	$header_overlapping = cloudfw_check_onoff('header', 'overlapping');
	if ( $header_overlapping ) {
		$classes[] = 'header-overlapping';
	}
	/*$header_overlapping_mobile = cloudfw_check_onoff('header', 'overlapping_mobile');
	if ( $header_overlapping_mobile ) {
		$classes[] = 'header-overlapping-mobile';
	}*/

	$sticky_footer = cloudfw_check_onoff('footer', 'sticky');
	if ( $sticky_footer ) {
		$classes[] = 'sticky-footer';
	}

	if ( cloudfw_get_visual_option('layout') == 'boxed' ) {

		$classes[] = 'layout--boxed';

		$background_image = cloudfw_get_skin_value('boxed_layout', 'background-image');
		$background_pattern = cloudfw_get_skin_value('boxed_layout', 'pattern');

		if ( !empty($background_image) || !empty($background_pattern) )
			$classes[] = 'helper--no-filter';

	} else {
		$classes[] = 'layout--fullwidth';
	}


	$side_panel_position = cloudfw_get_option('side_panel', 'position');
	if ( $side_panel_position == 'right' ) {
		$classes[] = 'ui--side-panel-position-right';
	} else {
		$classes[] = 'ui--side-panel-position-left';
	}

	$mobile_navigation_style = cloudfw_get_option('mobile_navigation', 'style');
	if ( $mobile_navigation_style == 'blocked' ) {
		$classes[] = 'ui--mobile-navigation-style-blocked';
	} else {
		$classes[] = 'ui--mobile-navigation-style-default';
	}

	return $classes;
}

/**
 *  CloudFw Device Viewport
 *
 *  @since 3.0
 */
function cloudfw_device_viewport( $echo = 1 ) {

	if ( cloudfw_is_responsive() ) {
		if ( ! cloudfw_check_onoff('global', 'scale_in_responsive') ) {
			$out = '<meta name="viewport" content="width=device-width, maximum-scale=1.0, minimum-scale=1.0">';
		} else {
			$out = '<meta name="viewport" content="width=device-width, initial-scale=1.0">';
		}
	} else {
		$out = '<meta name="viewport" content="width=1280px">';
	}

	if( $echo )
		echo $out;

	return $out;
}

/**
 *  CloudFw Favicon
 *
 *  @since 1.0
 */
function cloudfw_favicon( $echo = 1 ) {
	$out = '';

	/** All devices */
	if ( $favicon = cloudfw_get_option('favicon', '16') )
		$out .= "<link rel=\"shortcut icon\" href=\"{$favicon}\" />" . PHP_EOL;

	/**  iPhone */
	if ( $favicon = cloudfw_get_option('favicon', '57') )
		$out .= "<link rel=\"apple-touch-icon\" href=\"{$favicon}\" />" . PHP_EOL;

	/**  iPhone Retina */
	if ( $favicon = cloudfw_get_option('favicon', '114') )
		$out .= "<link rel=\"apple-touch-icon\" sizes=\"114x114\" href=\"{$favicon}\" />" . PHP_EOL;

	/**  iPad */
	if ( $favicon = cloudfw_get_option('favicon', '72') )
		$out .= "<link rel=\"apple-touch-icon\" sizes=\"72x72\" href=\"{$favicon}\" />" . PHP_EOL;

	/**  iPad Retina */
	if ( $favicon = cloudfw_get_option('favicon', '144') )
		$out .= "<link rel=\"apple-touch-icon\" sizes=\"144x144\" href=\"{$favicon}\" />" . PHP_EOL;


	if( $echo )
		echo $out;

	return $out;

}

/**
 *  CloudFw Custom CSS Code
 *
 *  @since 1.0
 */
function cloudfw_custom_css_code( $echo = 1 ) {
	$out = ''; 
	$css = array();
	$css[] = cloudfw_get_option( 'custom_codes', 'css' );
	$css[] = cloudfw_get_option( 'webfonts', 'codes' );

	if ( ! empty( $css ) ) {
		$css = implode("\n", $css);
		$css = trim( $css );
		if ( ! empty( $css ) ) {
			$out = "<style id=\"custom-css\" type=\"text/css\">{$css}</style>";
		}

		if( $echo ) {
			echo $out;
		}

		return $out;
	}
}

/**
 *  CloudFw Google Analytic Tracking Code Generator
 *
 *  @since 1.0
 */
function cloudfw_google_analytics_tracking($tracking_id){
	if (empty($tracking_id)) return false;
	echo '
<!-- Google Analytics -->
<script>
(function(i,s,o,g,r,a,m){i[\'GoogleAnalyticsObject\']=r;i[r]=i[r]||function(){
(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
})(window,document,\'script\',\'//www.google-analytics.com/analytics.js\',\'ga\');

ga(\'create\', \''. $tracking_id .'\', \'auto\');
ga(\'send\', \'pageview\');

</script>
<!-- End Google Analytics -->';
};




/**
 *    CloudFw Cufon Init
 *
 *    @since 1.0
 */
if ( current_theme_supports('cufon') && cloudfw_check_onoff('cufon', 'enable') ) {
	add_filter('wp_footer','cloudfw_cufon_init', 100);
}


/**
 *  Remove WordPress Version Information From Header for Security
 *
 *  @since 1.0
 */
remove_action('wp_head', 'wp_generator');


/**
 *    Widget Tag Cloud Filter
 *
 *    @since 1.0
 */
add_filter('widget_tag_cloud_args', 'cloudfw_widget_tag_cloudfw_ordering_filter');
function cloudfw_widget_tag_cloudfw_ordering_filter($args) {
  $args['smallest'] = 7;
  $args['largest'] = 7;
  return $args;
}

/**
 *    Register Sticky Nav
 *
 *    @since 1.0
 */
if ( cloudfw_check_onoff( 'header', 'sticky' ) ) {
	add_action  ('wp_head', 'cloudfw_register_sticky_nav', 20);
	function cloudfw_register_sticky_nav(){
		wp_enqueue_script ('theme-waypoints-sticky');

		$css = '';
		$css .= cloudfw_make_style( array(
				".modern-browser #header-container.stuck #logo img",
			), array(
				'height' 		=> cloudfw_get_option( 'logo-sticky', 'height', NULL, 0 ),
				'!margin-top' 	=> cloudfw_get_option( 'logo-sticky', 'margin-top' ),
				'!margin-bottom' => cloudfw_get_option( 'logo-sticky', 'margin-bottom' ),
			), FALSE, FALSE
		);

		$css = "@media ( min-width: 979px ) { {$css} }";
		cloudfw_vc_set( 'css', 'sticky-logo', $css );
		unset( $css );
	}
}

/**
 *    Register Preloader
 *
 *    @since 1.0
 */
if ( cloudfw_check_onoff( 'global', 'preloader' ) && ! wp_is_mobile() ) {
	add_action  ('wp_head', 'cloudfw_register_preloader');
	function cloudfw_register_preloader(){
		wp_enqueue_script ('theme-queryloader2');
	}
}

/**
 *    Register Preloader
 *
 *    @since 1.0
 */
if ( cloudfw_check_onoff( 'global', 'smoothscroll' ) ) {
	add_action  ('wp_head', 'cloudfw_register_smoothscroll', 20);
	function cloudfw_register_smoothscroll(){
		global $is_IE;

		if (!$is_IE) {
			wp_enqueue_script ('theme-smoothscroll');
		}
	}
}

/**
 *  Adds comments and related post after the page contents.
 */
add_filter( 'the_content', 'cloudfw_add_contents_after_pages', 11 );
function cloudfw_add_contents_after_pages( $content ) {
	if ( is_singular('page') && is_main_query() && cloudfw_get_post_meta(get_the_ID(), 'comments_allow') == 'on' && ! post_password_required() ) {
		ob_start();
		comments_template( '', true );
		$content .= ob_get_contents();
		ob_end_clean();
	}

	return $content;
}

/**
 *	Overrides header overlapping option.
 */
add_filter('cloudfw_option_header:overlapping', 'cloudfw_override_header_overlapping');
function cloudfw_override_header_overlapping( $data ){
	if ( ! is_admin() ){
		$page_setting = cloudfw_get_post_meta(get_queried_object_id(), 'spec_overlapping');
		if ( ! empty( $page_setting ) ) {
			return $page_setting;
		}

		$visual_data = cloudfw_get_visual_option("header_overlapping");
		if ( ! empty( $visual_data ) ) {
			return $visual_data;
		}
	}
	return $data;
}

/**
 *	Checks seo plugin is installed.
 */
add_filter('cloudfw_is_SEO_plugin', 'cloudfw_is_SEO_plugin');
function cloudfw_is_SEO_plugin( $return ){

	if ( cloudfw_is_wpseo() ) {
		$return = true;
	}

	return $return;
}

/**
 *    CloudFw Custom Tag Before Head
 *
 *    @since 1.0
 */
function cloudfw_custom_tag_before_head(){
	if ( current_theme_supports('W3C_compatibility') ) {
		echo '<!--CLOUDFW_BEFORE_HEAD-->';
	}
}

/**
 *
 */
function cloudfw_render_footer_to_header( $return = false ){
	$out = '';
	$codes = cloudfw_vc_get( 'footer_to_header' );
	cloudfw_vc_clear( 'footer_to_header' );
	if ( !empty($codes) && is_array($codes) ) {
		$out .= implode("\r\n\r\n", $codes);
	}

	if ( ! $return ) {
		echo $out;
	}

	return $out;
}


/**
 *
 */
function cloudfw_render_footer_css_file( $return = false ){
	$out = '';
	$css_files = cloudfw_vc_get( 'load_css' );

	cloudfw_vc_clear( 'load_css' );
	if ( !empty($css_files) && is_array($css_files) ) {
		if ( current_theme_supports('W3C_compatibility') ) {
			foreach ($css_files as $key => $fileurl) {
				$fileurl = add_query_arg( 'ver', cloudfw_get_combined_version(), $fileurl );
				$out .= "<link rel='stylesheet' id='{$key}' href='{$fileurl}' type='text/css' media='all'/>\r\n";
			}
		} else {
			$out = "\r\n<script type=\"text/javascript\">\r\n// <![CDATA[\r\n";
			foreach ($css_files as $key => $fileurl) {
				$out .= "\tcloudfw_load_css_file( '{$key}', '{$fileurl}' );\r\n";
			}
			$out .= "\r\n// ]]>\r\n</script>\r\n";
		}
	}

	if ( ! $return ) {
		echo $out;
	}

	return $out;
}

/**
 *
 */
function cloudfw_render_footer_css_codes( $return = false ){
	$custom_styles = cloudfw_vc_get( 'css' );
	cloudfw_vc_clear( 'css' );
	$css = '';

	if ( ! empty( $custom_styles ) && is_array( $custom_styles ) ) {
		$css = implode('', $custom_styles);

		if ( ! $return ) {

			if ( ! empty( $css ) ) {
				$css = str_replace(array("\r","\n","\t"), '', $css);
				$css = json_encode( $css );


				echo '
				<script type="text/javascript">
				// <![CDATA[
					var styleElement = document.createElement("style");
						styleElement.type = "text/css";

					var cloudfw_dynamic_css_code = '. $css .';

					if (styleElement.styleSheet) {
						styleElement.styleSheet.cssText = cloudfw_dynamic_css_code;
					} else {
						styleElement.appendChild(document.createTextNode( cloudfw_dynamic_css_code ));
					}

					document.getElementsByTagName("head")[0].appendChild(styleElement);

				// ]]>
				</script>
				';
			}

		} else {

			if ( ! empty( $css ) ) {
				$css = "\r\n" .'<style id="dynamic-css" type="text/css">'. $css .'</style>' . "\r\n\r\n";
			}

		}

	}

	return $css;
}

/**
 *
 */
function cloudfw_render_start(){
	ob_start( 'cloudfw_render_end' );
}

/**
 *
 */
function cloudfw_render_end( $buffer ){
	$before_head_content = '';
	$before_head_content .= cloudfw_render_footer_to_header( true );
	$before_head_content .= cloudfw_render_footer_css_file( true );
	$before_head_content .= cloudfw_render_footer_css_codes( true );

	if ( ! empty( $before_head_content ) ) {
		$buffer = str_replace( '<!--CLOUDFW_BEFORE_HEAD-->', $before_head_content, $buffer );
		unset( $before_head_content );
	}

	return $buffer;
}

/**
 *
 */
function cloudfw_print_late_styles() {
	cloudfw_fix_style_args();
	ob_start();
	print_late_styles();
	cloudfw_vc_set( 'footer_to_header', '_print_late_styles', ob_get_clean() );
	global $wp_styles;
	$wp_styles->queue = array();
}

/**
 *
 */
function cloudfw_fix_style_args() {
	/** Fix  */
	global $wp_styles;
	if ( is_array( $wp_styles->registered ) && ! empty( $wp_styles->registered ) ) {

		foreach ( $wp_styles->registered as $key => $value ) {
			if ( isset($wp_styles->registered[$key]->args) && $wp_styles->registered[$key]->args === false ) {
				$wp_styles->registered[$key]->args = 'screen';
			}
		}
	}
}

/**
 *	
 */
if ( current_theme_supports('W3C_compatibility') ) {
	add_action('template_redirect', 'cloudfw_render_start' );
	add_action('wp_footer', 'cloudfw_print_late_styles', 19 );
	add_action('wp_print_styles', 'cloudfw_fix_style_args', 9 );
} else {
	add_action('wp_footer', 'cloudfw_render_footer_to_header', 20 );
	add_action('wp_footer', 'cloudfw_render_footer_css_file', 20 );
	add_action('wp_footer', 'cloudfw_render_footer_css_codes', 1000 );
}
