<?php

/**
 *	CloudFw Page Generator Base
 *
 *	@since 1.0
 */
class CloudFw_Page_Generator_Base {
	/** Variables */
	public $ID;
	public $meta_cache;
	public $force_meta_load = false;
	public $option;
	public $loop;

	/**
	 *	__construct Function
	 *
	 *	@since 1.0
	 */
	function __construct() {
		global $post;

		$id = $this->get_ID();

		if ( $id === 0 ) {
			$id = '_0';
		}

		$this->ID = $id;
		$this->meta_cache = array();
		add_filter('cloudfw_skin_id', array( &$this, 'hook_skin'));
	}

	function engine(){
		return $this;
	}

	function set_ID( $id, $define = TRUE ) {
		if ( !$id )
			return;

		if ( $this->ID !== $id && $define )
			$this->set( '__page', $id );

		$this->ID = $id;
		$this->meta_cache = array();
		$this->force_meta_load = true;
	}

	function get_ID() {
		return $this->ID ? $this->ID : get_queried_object_id();
	}

	/**
	 *  Set Option
	 *
	 *  @since 1.0
	 */
	function set( $option = NULL, $value = NULL ) {
		$this->option[ $option ] = $value;
		return $value;
	}

	/**
	 *  Get Option
	 *
	 *  @since 1.0
	 */
	function get( $option = NULL, $default = NULL ) {
		return isset($this->option[ $option ]) ? $this->option[ $option ] : $default;
	}

	/**
	 *  Delete Option
	 *
	 *  @since 1.0
	 */
	function delete( $option = NULL ) {
		if ( isset($this->option[ $option ]) )
			 unset( $this->option[ $option ] );
	}

	/**
	 *  Get All Options
	 *
	 *  @since 1.0
	 */
	function get_all() {
		return isset($this->option) ? $this->option : NULL;
	}

	/**
	 *  Set Post Option
	 *
	 *  @since 1.0
	 */
	function set_loop( $option = NULL, $value = NULL ) {
		$this->loop[ $option ] = $value;
		return $value;
	}

	/**
	 *  Reset Post Option
	 *
	 *  @since 1.0
	 */
	function reset_loop() {
		unset( $this->loop );
	}

	/**
	 *  Get Post Option
	 *
	 *  @since 1.0
	 */
	function get_loop( $option = NULL ) {
		return isset($this->loop[ $option ]) ? $this->loop[ $option ] : NULL;
	}

   /**
	* Get Post Metas
	*
	* @since 1.0
	*/
	function get_all_metas( $id = NULL, $force = FALSE ) {
		if( ! isset( $id ) ) {
			$id = $this->get_ID();
		}

		if( empty( $id ) ) {
			return false;
		}

		if ( !isset( $this->meta_cache[ $id ] ) || $force  ) {
			global $wp_query;
			if ( ! $this->force_meta_load && ($wp_query->is_category || $wp_query->is_tag || $wp_query->is_tax) ) {
				// do not load metas
			} else {
				$this->meta_cache[ $id ] = get_post_meta( $id, FALSE );
				$this->meta_cache[ $id ] = apply_filters('cloudfw_post_metas', $this->meta_cache[ $id ], $id);
			}
		}

		return isset($this->meta_cache[ $id ]) ? $this->meta_cache[ $id ] : NULL;
	}

	/**
	 *  Get a Meta
	 *
	 *  @since 1.0
	 */
	function get_meta( $meta, $id = NULL, $pfix = TRUE ) {
		$metas = $this->get_all_metas( $id );

		if ( is_array($metas) ) {
			return isset($metas[ $pfix ? PFIX . '_' . $meta : $meta][0]) ? $metas[ $pfix ? PFIX . '_' . $meta : $meta][0] : NULL;
		}

	}

	/**
	 *  Set Meta Data
	 *
	 *  @since 1.0
	 */
	function set_meta( $meta, $data = NULL, $id = NULL, $pfix = TRUE ) {
		if( ! isset( $id ) )
			$id = $this->get_ID();

		$metas = $this->get_all_metas( $id );
		$this->meta_cache[ $id ][ $pfix ? PFIX . '_' . $meta : $meta][0] = $data;
	}

	/**
	 *    Get Post Type
	 *
	 *    @since 3.0
	 */
	function get_post_type(){
		return get_post_type( $this->ID );
	}

	/**
	 *    Get Composer Meta
	 *
	 *    @since 3.0
	 */
	function get_composer_content(){
		return cloudfw_composer_get_data( $this->ID );
	}

	/**
	 *    Change Skin
	 */
	function hook_skin( $current_skin_id ) {
		$skin = $this->get('skin');

		/*echo '<pre>';
		 var_dump($skin);
		echo '</pre>';
		exit;*/

		if ( !empty($skin) )
			return $skin;
		else
			return $current_skin_id;

	}

	/**
	 *  Set Option
	 *
	 *  @since 1.0
	 */
	function check( $what = NULL ) {

		switch ($what) {
			default:
			case 'type':
				if( $this->get('is_checked:default') )
					return;

				$this->set('is_checked:default', true);
				$layout = $this->get_layout();
				if ( post_password_required( $this->get_ID() ) ) {
					$layout =  'page-fullwidth.php';
				}

				if ( $custom_skin = $this->get_meta('custom_skin') ) {
					$this->set('skin', $custom_skin );
				}

				do_action( 'cloudfw_check_type', $this );


				if ( !empty( $layout ) ) {
					$this->return_layout( $layout );
				}

				break;
			case 'is_blog':

				if ( is_blog() && ! $this->get('skip_is_blog') ) {

					/** Is checked before? */
					if( $this->get('is_checked:blog') )
						return;


					if( isset( $_GET['s'] ) && empty( $_GET['s'] ) ) {
						$this->set_meta( 'titlebar_title', cloudfw_translate( 'enter_a_term_to_search' ) );
						$this->set_meta( 'breadcrumb', 'no' );
					}

					/** Set the page is checked */
					$this->set('is_checked:blog', true);
					$this->set('blog', true);

				}

			break;

		}

	}

	/**
	 *    Returns the blog page's id.
	 *
	 *    @since 1.0
	 */
	function blog_page_id(){
		return get_option( 'page_for_posts' );
	}

	/**
	 *    Blog Page Layout
	 *
	 *    @since 1.0
	 */
	function blog_page_layout(){
		return $this->get_meta( '_wp_page_template', $this->blog_page_id(), 0 );
	}

	/**
	 *    Returns a page layout.
	 *
	 *    @since 1.0
	 */
	function return_layout( $layout ){
		if ( empty($layout) || $layout == 'default' ) {
			$layout = 'page.php';
		}

		if( !empty( $layout ) && file_exists( TMP_PATH . "/$layout" ) ) {
			require( TMP_PATH . "/$layout" );
			exit;
		} else {
		   $this->set('layout_page', $layout);
		}
	}

	/**
	 *  Global Site Title
	 *
	 *  @since 1.0
	 */
	function title() {

		$seo_plugin = apply_filters( 'cloudfw_is_SEO_plugin', false );
		$seperator = cloudfw_get_option( 'global', 'page_title_seperator' );

		if ( $seo_plugin ) {

			wp_title( $seperator, true, 'left' );

		} else {

			$layout = cloudfw_get_option( 'global', 'page_title_layout' );

			global $page, $paged;

			if ( $layout == 'first_title' ) {
				wp_title( $seperator, true, 'right' );
				bloginfo( 'name' );
			} else {
				bloginfo( 'name' );
				wp_title( $seperator, true, 'left' );
			}

			$site_description = get_bloginfo( 'description', 'display' );
			if ( !empty($site_description) && ( is_home() || is_front_page() ) ) {
				echo " {$seperator} {$site_description}";
			}

			if ( $paged >= 2 || $page >= 2 ) {
				echo " {$seperator} " . sprintf( __( 'Page %s', 'cloudfw' ), max( $paged, $page ) );
			}

		}

	}

	/**
	 *  Get Slider
	 *
	 *  @since 1.0
	 */
	function get_slider() {
		$slider_id = $this->get_meta('top_slider');

		if ( !empty( $slider_id ) ) {
			echo do_shortcode('[slider id="'.$slider_id.'"]');
		}

	}

	/**
	 *	Get Pagination
	 *
	 *	@since 1.0
	 */
	function pagination( $atts = array() ) {
		if ( function_exists( 'cloudfw_pagination' ) ){
			return cloudfw_pagination( $atts );
		}
	}

	/**
	 *  Not Found
	 *
	 *  @since 1.0
	 */
	function not_found() {
		if( file_exists( TMP_INCLUDES . "/layouts/not_found.php" ) )
			require( TMP_INCLUDES . "/layouts/not_found.php" );
		else
			_e('Not Found','cloudfw');

	}

	/**
	 *    Check if it's bbpress page
	 */
	function is_bbpress(){
		if ( function_exists('is_bbpress') )
			return is_bbpress();
		else
			return false;

	}

	/**
	 *  Get Sidebar ID
	 *
	 *  @since 1.0
	 */
	function get_sidebar_id() {
		$custom_sidebar = $this->get('custom_sidebar');
		return !empty( $custom_sidebar ) ? $custom_sidebar : $this->get_meta('custom_sidebar');
	}

	/**
	 *  Get Secondary Sidebar ID
	 *
	 *  @since 1.0
	 */
	function get_sidebar_secondary_id() {
		$custom_sidebar = $this->get('custom_sidebar_2');
		return !empty( $custom_sidebar ) ? $custom_sidebar : ( $this->get_meta('custom_sidebar_2') ? $this->get_meta('custom_sidebar_2') : 'secondary-widget-area' );
	}

	/**
	 *  Get Layout
	 *
	 *  @since 1.0
	 */
	function get_layout() {
		$force = $this->get('force_layout');

		if ( !empty($force) ) {
			return $force;
		}

		$layout = $this->get_meta( '_wp_page_template', NULL, 0 );
		$out = !empty( $layout ) ? $layout : $this->get('layout');

		return $out;
	}

	/**
	 *  Comment Form
	 *
	 *  @since 1.0
	 */
	function comment_form( $args = array(), $post_id = null ) {
		if( file_exists( TMP_PATH . "/comment-form.php" ) )
			require( TMP_PATH . "/comment-form.php" );
		else
			echo cloudfw_error_message(__('Comment form template cannot found','cloudfw'));
	}

}