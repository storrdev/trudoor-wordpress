<?php

/*
 * Plugin Name: Galleries
 * Plugin URI: http://cloudfw.net
 * Description:
 * Version: 1.0
 * Author: Orkun Gürsel
 * Author URI: http://orkungursel.com
 * Shortcode:
 * Attributes:
 */
cloudfw_register_shortcode( 'CloudFw_Shortcode_Gallery', NULL, 'advanced', 70 );
if ( ! class_exists('CloudFw_Shortcode_Gallery') ) {
	class CloudFw_Shortcode_Gallery extends CloudFw_Shortcodes {

		function get_called_class(){ return get_class($this); }

		var $atts   = array();
		var $header = '';
		var $footer = '';
		var $content= '';
		var $instant= 0;
		var $id     = '';
		var $total  = 0;
		var $item_number  = 0;
		var $parent_shortcode = 'cfw_gallery';
		var $children_shortcode = 'cfw_gallery_item';

		function CloudFw_Shortcode_Gallery() {
			add_action('cloudfw_javascript_options', array( &$this, 'js_options' ));
		}

		function add() {
			return array(
				$this->parent_shortcode     => array( &$this, 'parent' ),
				$this->children_shortcode   => array( &$this, 'item' ),
			);
		}

		/*
		 *  Shortcode via Composer
		 */
		function shortcode($atts, $content =  NULL, $case = NULL){

			$content_array = array();
			foreach ( (array) $atts['indicator'] as $i => $dummy )
				$content_array[] = cloudfw_transfer_shortcode_attributes(
					$this->children_shortcode,
					array(
						'image'     => $atts['gallery_image'][ $i ],
						'link'      => $atts['gallery_link'][ $i ],
						'title'     => $atts['gallery_title'][ $i ],
						'desc'      => $atts['gallery_desc'][ $i ]
					),
					NULL,
					FALSE
				);

			if ( ! empty( $content_array ) ) {
				if ( isset($atts['random']) && _check_onoff($atts['random']) ) {
					shuffle( $content_array );
				}
				$content .= implode('', $content_array);
			}

			return cloudfw_transfer_shortcode_attributes( $this->parent_shortcode, $atts, $content );
		}

		/*
		 *  Shortcode via Manual Code
		 */
		function parent($atts, $content =  NULL, $case = NULL){
			$this->atts = shortcode_atts(array(
				'device'       => NULL,
				'columns'      => 3,
				'width'        => NULL,
				'height'       => NULL,
				'crop'         => true,
				'lightbox'     => true,
				'disable_links'=> '',
				'carousel'     => 'FALSE',
				'random'       => 'FALSE',
				'button_icon'  => 'fontawesome/fontawesome-fullscreen',
				'button_color' => '',
				'carousel_effect' => '',
				'carousel_autorotate' => 'FALSE',
			), _check_onoff_false($atts));

			if ( empty($this->atts['disable_links']) ) {
				$this->atts['disable_links'] = false; 
			}

			extract( $this->atts );

			$this->header   = '';
			$this->footer   = '';
			$this->contents = '';

			$this->instant++;
			$this->id = 'ui--gallery-' . $this->instant;

			$this->item_number = 0;
			$this->total = 0;
			$this->total = count(explode("[cfw_gallery_item",$content)) - 1;

			do_shortcode($content);

			$lightbox = _check_onoff( $lightbox );
			$carousel = _check_onoff( $carousel )  && (int) $this->total > (int) $columns;

			$class  = 'unstyled-all clearfix';
			$class .= ' ui--gallery-wrapper';
			$class .= ' columns-' . $columns;
			$class .= ' ' . cloudfw_visible( $device );

			$this->header .= '<div' .
				cloudfw_make_id( $this->id ) .
				cloudfw_make_class(array(
					'ui--gallery',
					'ui--pass',
				), true) .
				cloudfw_make_attribute( array(
					'data-columns'      => $columns,
				), FALSE ).
			'>';

				$this->header .= '<div'.
					cloudfw_make_class(array( $class ), true)
				.'>';

				$this->footer  = "";
				$this->footer .= "</div>";
			$this->footer .= "<div class=\"clearfix\"></div>";
			$this->footer .= "</div>";

			if ( $carousel ) {
				$this->contents = cloudfw_make_layout( 'carousel', $this->contents, array( 'auto_rotate' => $carousel_autorotate, 'effect' => $carousel_effect ) );
			}

			$out =  $this->header.
					$this->contents.
					$this->footer;

			return $out;

		}

		/**
		 *  Items
		 */
		function item($atts, $content =  NULL, $case = NULL){
			extract(shortcode_atts(array(
				'image'         => '',
				'thumbnail'     => '',
				'link'          => '',
				'title'         => '',
				'desc'          => '',
			), $atts));

			$this->item_number++;

			/*if ( !$image ) {
				return;
			}*/

			if ( ! $link ) {
				$link = $image;
			}

			$disable_links = $this->atts['disable_links'];
			if ( $disable_links ){
				$link = false;
			}

			$width =  (int) $this->atts['width'];
			$height =  (int) $this->atts['height'];

			$size = array();
			$size['w'] = 500;
			$size['h'] = 500;

			if ( (int) $this->atts['columns'] == 1 ) {
				$size['w'] = 960;
				$size['h'] = 500;
			}

			if ( $width > 0 ) {
				$size['w'] = $width;
			}

			if ( $height > 0 ) {
				$size['h'] = $height;
			}

			if ( $this->atts['crop'] )
				$image = cloudfw_thumbnail(array('src' => $image, 'w' => $size['w'], 'h' => $size['h'], 'cache' => 0));

			$item_out = '<div class="ui--gallery-item ui--animation">';
				$item_out .= '<div class="inner">';

					if ( $link ) {
						$target = '_blank';
						$item_out .= '<a href="'. esc_attr( $link ) .'"';
							$item_out .= isset($target) && $target ? ' target="' . $target . '"' : NULL;
							$item_out .= isset($desc) && $desc ? ' data-title="' . esc_attr($desc) . '"' : NULL;
							$item_out .= isset($this->atts['lightbox']) && $this->atts['lightbox'] ? ' data-rel="prettyPhoto['.$this->id.']"' : NULL;
						$item_out .= '>';
					}

					$item_out .= '<img src="'. $image .'" class=""';
						$item_out .= isset($title) && !empty( $title ) ? ' alt="' . esc_attr($title) . '"' : ' alt="' . esc_attr(get_the_title()) . '"';
					$item_out .= '/>';
					$item_out .= '<div class="ui--gallery-overlay"><div class="center">';
						$item_out .= cloudfw_create_button(array(
							'element' => 'span',
							//'link'	=> 'javascript:;',
							'color' => !empty( $this->atts['button_color'] ) ? $this->atts['button_color'] : 'btn-grey',
							'block' => false,
							'lightbox' => false,
							'echo' => false,
						), cloudfw_make_icon($this->atts['button_icon']));
					$item_out .= '</div></div>';

					if ( $link ) {
						$item_out .= '</a>';
					}

				$item_out .= '</div>';
			$item_out .= '</div>';
			$item_out .= "\n";

			$column_array = array();
			$column_array['_key'] = 'gallery';
			$this->contents .= cloudfw_UI_column( $column_array, $item_out, '1of' . $this->atts['columns'] . ( $this->item_number % $this->atts['columns'] == 0 ? '_last' : '' ), $this->item_number == $this->total );


		}

		/** Add the shortcode to the composer */
		function composer(){
			return array(
				'composer'      => true,
				'droppable'     => false,
				'ajax'          => true,
				'icon'          => 'gallery',
				'group'         => 'composer_widgets',
				'line'          => 320,
				'options'       => array(
					'title'             => __('Gallery','cloudfw'),
					'column'            => '1/1',
					'allow_columns'     => false
				)
			);
		}

		/** Admin Scheme */
		function scheme() {

			return array(
				'title'     =>  __('Gallery','cloudfw'),
				'ajax'      =>  true,
				'script'    => array(
					'shortcode'     => $this->parent_shortcode,
					'tag_close'     => true,
					'tag_newline'   => false,
					'attributes'    => array(
						'device'            => array( 'e' => 'the_device' ),
						'columns'           => array( 'e' => 'gallery_columns' ),
						'crop'              => array( 'e' => 'gallery_crop' ),
						'width'             => array( 'e' => 'gallery_width' ),
						'height'            => array( 'e' => 'gallery_height' ),
						'disable_links'     => array( 'e' => 'disable_links' ),
						'lightbox'          => array( 'e' => 'gallery_lightbox' ),
						'random'            => array( 'e' => 'gallery_random', 'onoff' => true ),
						'carousel'          => array( 'e' => 'gallery_carousel' ),
						'carousel_effect'   => array( 'e' => 'gallery_carousel_effect' ),
						'carousel_autorotate' => array( 'e' => 'gallery_carousel_autorotate', 'onoff' => true ),
						'button_icon'       => array( 'e' => 'button_icon' ),
						'button_color'      => array( 'e' => 'button_color' ),
						'content'           => array(
							'e'                 => 'gallery_all',
							'multi'             => 'gallery_clone_class',
							'check_visiblity'   => false,
							'tag_newline'       => false,
							'data'              => array(

								array(
									'id'      => $this->children_shortcode,
									'script'  => array(
										'shortcode'     => $this->children_shortcode,
										'tag_close'     => false,
										'tag_newline_default' => true,
										'prepend'       => '\'+$tb+\'',
										'attributes'    => array(
											'image'         => array( 'e' => 'gallery_image', 'check_visiblity'  => false ),
											'link'          => array( 'e' => 'gallery_link', 'check_visiblity'   => false ),
											'title'         => array( 'e' => 'gallery_title', 'check_visiblity'  => false ),
											'desc'          => array( 'e' => 'gallery_desc', 'check_visiblity'   => false ),
										)
									),
								)

							)

						),
					),

				),
				'data'      =>  $this->load_scheme( __FILE__ )


			);

		}


		/**
		 *  Javascript options
		 */
		function js_options(){
			$hover_opacity = cloudfw_get_visual_option('gallery-opacity');

			if ( !$hover_opacity ) {
				$hover_opacity = 90;
			}

			cloudfw_set_js('gallery_overlay_opacity', $hover_opacity );
		}


		/** Skin map */
		function skin_map( $map ){
			$map  -> id      ( 'options' )
				  -> attr    ( 'gallery-opacity', 90);

			$map  -> id      ( 'gallery_overlay' )
				  -> selector( '.ui--gallery-overlay' )
				  -> attr    ( 'background-color', '', true );

			return $map;

		}

		/** Skin scheme */
		function skin_scheme( $schemes, $data ){
			return cloudfw_add_skin_scheme( 'shortcode',
				$schemes,
				array(
					'type'      =>  'module-set',
					'title'     =>  __('Galleries','cloudfw'),
					'closable'  =>  true,
					'state'     =>  'closed',
					'data'      =>  array(

						array(
							'type'      =>  'module',
							'ucode'     =>  'GALLERY OVERLAY',
							'title'     =>  __('Gallery Overlay Opacity','cloudfw'),
							'data'      =>  array(

								array(
									'type'      =>  'slider',
									'id'        =>  cloudfw_sanitize('options','gallery-opacity'),
									'value'     =>  $data['options']['gallery-opacity'],
									'min'       =>  0,
									'max'       =>  100,
									'step'      =>  5,
									'unit'		=>	'%',
									'width'     =>  250,
								),

							)

						),

						array(
							'type'      =>  'module',
							'ucode'     =>  'GALLERY OVERLAY',
							'title'     =>  __('Gallery Overlay Color','cloudfw'),
							'data'      =>  array(

								array(
									'type'      =>  'color',
									'id'        =>  cloudfw_sanitize('gallery_overlay','background-color'),
									'value'     =>  $data['gallery_overlay']['background-color'],
								),

							)

						),


					) // module set data

				),

				5 // seq

			);

		}


	}

}