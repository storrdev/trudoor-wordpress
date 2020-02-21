<?php
/*
 * Plugin Name: Hidden Content
 * Plugin URI: http://cloudfw.net
 * Description: 
 * Version: 1.0
 * Author: Orkun Gürsel
 * Author URI: http://orkungursel.com
 */
cloudfw_register_shortcode( 'CloudFw_Composer_Hidden_Content', 'hidden_content', 'columns', 25  );
if ( ! class_exists('CloudFw_Composer_Hidden_Content') ) {
	class CloudFw_Composer_Hidden_Content extends CloudFw_Shortcodes {

		function get_called_class(){ return get_class($this); }


		/** Add the shortcode to the composer */
		function composer(){
			return array(
				'composer'		=> true,
				'droppable'		=> true,
				'ajax'			=> true,
				'icon'			=> 'html-responsive',
				'group'			=> 'composer_layouts',
				'line'			=> 40,
				'options'		=> array(
					'title'				=> __('Hidden Content','cloudfw'),
					'column'			=> '1/1',
					'allow_columns'		=> false,
					'allow_edit'		=> false,
				)
			);
		}

		/** Run */
		function shortcode( $atts = array(), $content =  NULL, $case = NULL ) {
			return '';
		}

		/** Scheme */
		function scheme() {
			return array(
				'title'		=>	__('Hidden Content','cloudfw'),
				'script'	=> array(
					'shortcode' 	=> 'responsive',
					'tag_close'  	=> true,
					'attributes' 	=> array( 
						'content' 	=> array( 'e' => 'responsive_content' ),
					)
				),
				'data'		=>  $this->load_scheme( __FILE__ )
			);

		}

		/** Scheme */
		function composer_scheme() {
			return array(
				'data'		=>	array(
					cloudfw_composer_default_dropped_area()
				)
			);
		}

	}

}