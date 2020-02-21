<?php

if ( ! cloudfw_woocommerce() ) {
	return;
}

if ( cloudfw_wc_is_quick_view() ) {
	show_admin_bar( false );
}

add_filter('cloudfw_woocommerce_media_append', 'custom_cloudfw_woocommerce_loop_footer_action_after_yith_quickview');
function custom_cloudfw_woocommerce_loop_footer_action_after_yith_quickview( $content ){
	if ( ! cloudfw_check_onoff( 'woocommerce', 'quick_view' ) ) {
		return;
	}
	global $wp, $product;
	$current_url = urlencode(( add_query_arg( NULL, NULL ) ));


	$url = add_query_arg( array(
		'qv' => 'true',
		'parent' => $current_url,
		'iframe' => 'true',
		'width' => trim( str_replace('px', '', cloudfw_get_option( 'woocommerce', 'quick_view_width', '80%' ) ) ),
		'height' => trim( str_replace('px', '', cloudfw_get_option( 'woocommerce', 'quick_view_height', '100%' ) ) ),
	), get_permalink( $product->id ) );

	return '<div class="ui--quickview-button"><div data-href="' . esc_attr( $url ) . '" class="btn btn-block btn-small ' . 
		esc_attr( cloudfw_make_button_style( cloudfw_get_option('woocommerce_button_color', 'quick_view', 'btn-primary'), true ) ) . '">'. cloudfw_translate('wc.catalog.quick_view') .'</div></div>';
}