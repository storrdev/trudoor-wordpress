<?php
/**
 * Single Product Price, including microdata for SEO
 *
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.4.9
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product;

?>
<div itemprop="offers" itemscope itemtype="http://schema.org/Offer">

	<h2 class="price woocommerce-page-price">
		<strong><?php echo $product->get_price_html(); ?></strong>
		<?php 
			if ( get_option('woocommerce_enable_review_rating') == 'yes' ) {
				echo cloudfw_wc_rating_icons( '<div class="ui--star-rating-wrap">', '</div>', NULL, false );
			}
		?>
	</h2>

	<meta itemprop="price" content="<?php echo esc_attr( $product->get_price() ); ?>" />
	<meta itemprop="priceCurrency" content="<?php echo esc_attr( get_woocommerce_currency() ); ?>" />
	<link itemprop="availability" href="http://schema.org/<?php echo $product->is_in_stock() ? 'InStock' : 'OutOfStock'; ?>" />

</div>