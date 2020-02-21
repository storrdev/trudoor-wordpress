<?php
/*
 * Plugin Name: Comment Out
 * Plugin URI: http://cloudfw.net
 * Description:
 * Version: 1.0
 * Author: Orkun Gürsel
 * Author URI: http://orkungursel.com
 * Shortcode:  [the_content]
 * Attributes: (int) id
 */

cloudfw_register_shortcode( 'CloudFw_Shortcode_Comment_Out', 'comment_out', 'advanced', 30 );
if ( ! class_exists('CloudFw_Shortcode_Comment_Out') ) {
	class CloudFw_Shortcode_Comment_Out extends CloudFw_Shortcodes {

		function get_called_class(){ return get_class($this); }


		/** Add the shortcode to the composer */
		function composer(){
			return array(
				'composer'		=> true,
				'droppable'		=> true,
				'ajax'			=> true,
				'icon'			=> 'page-content',
				'group'			=> 'composer_widgets',
				'line'			=> 380,
				'options'		=> array(
					'title'				=> __('Comment Out','cloudfw'),
					'column'			=> '1/1',
					'allow_columns'		=> false,
				)
			);
		}

		/** Run */
		function shortcode( $atts = array(), $content =  NULL, $case = NULL ) {
			extract(shortcode_atts(array(
				'enable'      => '',
			), _check_onoff_false($atts)));

			$content = do_shortcode( $content );

			return $enable ? "<!-- {$content} -->" : $content;
		}

		/** Scheme */
		function scheme() {
			return array(
				'title'		=>	__('Comment Out','cloudfw'),
				'ajax'		=>	true,
				'type'		=>	'shortcode:sub',
				'id'		=>	'comment_out',
				'script'	=> array(
					'shortcode'		=> 'comment_out',
					'tag_close'  	=> true,
					'attributes' 	=> array(
						'enable' 	=> array( 'e' => 'enable', 'onoff' => true ),
						'content' 	=> array( 'e' => 'comment_out_content' ),
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