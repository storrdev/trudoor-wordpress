<?php
/**
 * Single Product Thumbnails
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/product-thumbnails.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.6.3
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $post, $product, $woocommerce;

$attachment_ids = (array) $product->get_gallery_attachment_ids();
$attachment_ids = array_merge( array( get_post_thumbnail_id() ), $attachment_ids);
$attachment_ids = array_filter( $attachment_ids );

if ( count($attachment_ids) > 1 ) {

	$gallery = array();
	foreach ( $attachment_ids as $attachment_id ) {

		$image_link = wp_get_attachment_url( $attachment_id );

		if ( ! $image_link )
			continue;

		$image 		 = wp_get_attachment_image_src( $attachment_id, 'large');
		//$image_class = esc_attr( implode( ' ', isset($classes) ? $classes : array() ) );
		//$image_title = esc_attr( get_the_title( $attachment_id ) );

		$gallery[] 	 = array( 'src' => $image[0], 'link' => $image_link );

	}


	$image_width = 200;  
	$image_height = cloudfw_match_ratio( $image_width, '1:1' );

	$gallery_content = cloudfw_UI_gallery() 
			-> set('id', 'ui--shop-slider-carousel')
			-> set('class', 'ui--shop-gallery ui--shop-slider-carousel-' . get_the_ID())
			-> set('slides_element', 'ul')
			-> set('item_element', 'li')
			-> set('slides_class', 'slides')
			-> set('item_class', 'ui--shop-gallery-item')
			-> set('image_class', 'ui--shop-gallery-image')
			-> set('width', $image_width)
			-> set('height', $image_height)
			-> items( $gallery )
			-> render();

	echo $gallery_content;

}