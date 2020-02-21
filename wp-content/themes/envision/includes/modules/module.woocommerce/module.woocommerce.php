<?php

/*
 * Plugin Name: WooCommerce
 * Plugin URI: http://cloudfw.net
 * Description:  
 * Version: 1.0
 * Author: Orkun Gürsel
 * Author URI: http://orkungursel.com
 */
if ( cloudfw_woocommerce() ) {
	if ( file_exists(dirname(__FILE__) . '/woocommerce.php') )
	   include_once( dirname(__FILE__) . '/woocommerce.php' );

	if ( file_exists(dirname(__FILE__) . '/module.options.php') )
	   include_once( dirname(__FILE__) . '/module.options.php' );

	if ( file_exists(dirname(__FILE__) . '/module.shortcode.php') )
	   include_once( dirname(__FILE__) . '/module.shortcode.php' );

	if ( file_exists(dirname(__FILE__) . '/module.hooks.php') )
	   include_once( dirname(__FILE__) . '/module.hooks.php' );
	
	add_filter( 'woocommerce_enqueue_styles', '__return_false' );
}

remove_action( 'woocommerce_before_main_content','woocommerce_breadcrumb', 20, 0);

/**
 *	Filter for Product per page
 */
add_filter( 'woocommerce_placeholder_img_src', 'cloudfw_wc_placeholder_img_src' );
function cloudfw_wc_placeholder_img_src( $size ) {
	return cloudfw_placeholder( 'shop', $size );
}

add_filter('cloudfw_post_thumbnails', 'cloudfw_module_activate_featured_images_for_products');
function cloudfw_module_activate_featured_images_for_products( $post_types ) {
    $post_types[] = 'product';
    return $post_types;
}

/**
 *	Filter for Product per page
 */
add_filter( 'loop_shop_per_page', 'cloudfw_loop_shop_per_page', 20 );
function cloudfw_loop_shop_per_page( $cols ) {
	$default = cloudfw_get_option( 'woocommerce', 'catalog_post_perpage', 24 );

	if ( ! (int) $default > 0 ) {
		$default = 24;
	}

	$show_products = isset($_GET['show_products']) ? (int) $_GET['show_products'] : $default;
	return $show_products ? $show_products : $default;
}

/**
 *	Force login page for layout
 */
add_filter( 'cloudfw_check_type', 'cloudfw_wc_check_page' );
function cloudfw_wc_check_page( $that ) {

	if ( cloudfw_woocommerce() && ! is_user_logged_in() ) {
		$myaccount_page_id = (int) woocommerce_get_page_id( 'myaccount' );
		$current_page_id = (int) $that->get_ID(); 

		if ( $current_page_id > 0 && $current_page_id === $myaccount_page_id ) {
			$that->set( 'force_layout', 'page.php' );
			$that->return_layout( 'default' );
		}
	}

}

/**
 * Makes badge for Products
 * @param  string $location
 * @return string
 */
function cloudfw_wc_badge( $location = '' ) {
	global $post, $product;

	$badge = ''; 
	if ( ! $product->is_in_stock() ) {
		$badge = '<span class="out-of-stock-badge">'. cloudfw_translate( 'wc.loop.badge.out_of_stock' ) .'</span>';
	} elseif ( $product->price === '0' || $product->price === 0 ) {
		$badge = '<span class="free-badge">'. cloudfw_translate( 'wc.loop.badge.free' ) .'</span>';
	} elseif ($product->is_on_sale()) {
		$badge = apply_filters('woocommerce_sale_flash_on_sale', '<span class="onsale">'. cloudfw_translate( 'wc.loop.badge.sale' ) .'</span>', $post, $product);
	}
	
	$badge = apply_filters( 'woocommerce_sale_flash', $badge, $post, $product );

	if ( !empty( $badge ) ) {
		if ( $location == 'loop' ) {
			$badge = '<span class="ui--wc-badge">'. $badge .'</span>';
		}
	}

	return $badge;

}


function cloudfw_wc_rating_icons( $before = '', $after = '', $product = NULL, $microdata = true ) {
	if ( ! $product ) {
		global $product;
	}

	$out = ''; 
	$count = $product->get_rating_count();
	if ( $count > 0 ) {

		$average = $product->get_average_rating();
		if ( $microdata ) {
			$out = '
				<div class="ui--star-rating" itemprop="aggregateRating" itemscope itemtype="http://schema.org/AggregateRating" title="'.sprintf(__( 'Rated %s out of 5', 'woocommerce' ), $average ).'">
					<div class="ui--star-rating-text hidden"><strong itemprop="ratingValue" class="rating">'.$average.'</strong> '.__( 'out of 5', 'woocommerce' ).'</div>
					<meta itemprop="ratingCount" content="'. $count .'">
					<div class="ui--star-rating-background">
						<i class="ui--star icon fontawesome-star-empty"></i>
						<i class="ui--star icon fontawesome-star-empty"></i>
						<i class="ui--star icon fontawesome-star-empty"></i>
						<i class="ui--star icon fontawesome-star-empty"></i>
						<i class="ui--star icon fontawesome-star-empty"></i>
					</div>
					<div class="ui--star-rating-highlight" style="width:'.( ( $average / 5 ) * 100 ) . '%">
						<i class="ui--star icon fontawesome-star"></i>
						<i class="ui--star icon fontawesome-star"></i>
						<i class="ui--star icon fontawesome-star"></i>
						<i class="ui--star icon fontawesome-star"></i>
						<i class="ui--star icon fontawesome-star"></i>
					</div>
				</div>

			';
		} else {
			$out = '
				<div class="ui--star-rating" title="'.sprintf(__( 'Rated %s out of 5', 'woocommerce' ), $average ).'">
					<div class="ui--star-rating-text hidden"><strong class="rating">'.$average.'</strong> '.__( 'out of 5', 'woocommerce' ).'</div>
					<div class="ui--star-rating-background">
						<i class="ui--star icon fontawesome-star-empty"></i>
						<i class="ui--star icon fontawesome-star-empty"></i>
						<i class="ui--star icon fontawesome-star-empty"></i>
						<i class="ui--star icon fontawesome-star-empty"></i>
						<i class="ui--star icon fontawesome-star-empty"></i>
					</div>
					<div class="ui--star-rating-highlight" style="width:'.( ( $average / 5 ) * 100 ) . '%">
						<i class="ui--star icon fontawesome-star"></i>
						<i class="ui--star icon fontawesome-star"></i>
						<i class="ui--star icon fontawesome-star"></i>
						<i class="ui--star icon fontawesome-star"></i>
						<i class="ui--star icon fontawesome-star"></i>
					</div>
				</div>

			';		}

		$out = $before . $out . $after;

	}

	return $out;
}

add_action( 'product_cat_add_form_fields', 'cloudfw_add_woocommerce_category_fields', 11 );
add_action( 'product_cat_edit_form_fields', 'cloudfw_edit_woocommerce_category_fields', 11 );
add_action( 'created_term', 'cloudfw_woocommerce_save_category_fields', 10, 3 );
add_action( 'edit_term', 'cloudfw_woocommerce_save_category_fields', 10, 3 );
function cloudfw_add_woocommerce_category_fields(){
	?>
		<div class="form-field">
			<label><?php _e( 'Hover Thumbnail', 'woocommerce' ); ?></label>
			<div id="product_cat_hover_thumbnail" style="float: left; margin-right: 10px;"><img src="<?php echo esc_url( wc_placeholder_img_src() ); ?>" width="60px" height="60px" /></div>
			<div style="line-height: 60px;">
				<input type="hidden" id="product_cat_hover_thumbnail_id" name="product_cat_hover_thumbnail_id" />
				<button type="button" class="hover_upload_image_button button"><?php _e( 'Upload/Add image', 'woocommerce' ); ?></button>
				<button type="button" class="hover_remove_image_button button"><?php _e( 'Remove image', 'woocommerce' ); ?></button>
			</div>
			<script type="text/javascript">

				// Only show the "remove image" button when needed
				if ( ! jQuery( '#product_cat_hover_thumbnail_id' ).val() ) {
					jQuery( '.hover_remove_image_button' ).hide();
				}

				// Uploading files
				var hover_file_frame;

				jQuery( document ).on( 'click', '.hover_upload_image_button', function( event ) {

					event.preventDefault();

					// If the media frame already exists, reopen it.
					if ( hover_file_frame ) {
						hover_file_frame.open();
						return;
					}

					// Create the media frame.
					hover_file_frame = wp.media.frames.downloadable_file = wp.media({
						title: '<?php _e( "Choose an image", "woocommerce" ); ?>',
						button: {
							text: '<?php _e( "Use image", "woocommerce" ); ?>'
						},
						multiple: false
					});

					// When an image is selected, run a callback.
					hover_file_frame.on( 'select', function() {
						var attachment = hover_file_frame.state().get( 'selection' ).first().toJSON();

						jQuery( '#product_cat_hover_thumbnail_id' ).val( attachment.id );
						jQuery( '#product_cat_hover_thumbnail' ).find( 'img' ).attr( 'src', attachment.sizes.thumbnail.url );
						jQuery( '.hover_remove_image_button' ).show();
					});

					// Finally, open the modal.
					hover_file_frame.open();
				});

				jQuery( document ).on( 'click', '.hover_remove_image_button', function() {
					jQuery( '#product_cat_hover_thumbnail' ).find( 'img' ).attr( 'src', '<?php echo esc_js( wc_placeholder_img_src() ); ?>' );
					jQuery( '#product_cat_hover_thumbnail_id' ).val( '' );
					jQuery( '.hover_remove_image_button' ).hide();
					return false;
				});

			</script>
			<div class="clear"></div>
		</div>
		<?php
}

function cloudfw_edit_woocommerce_category_fields( $term ){

		$thumbnail_id = absint( get_woocommerce_term_meta( $term->term_id, 'hover_thumbnail_id', true ) );

		if ( $thumbnail_id ) {
			$image = wp_get_attachment_thumb_url( $thumbnail_id );
		} else {
			$image = wc_placeholder_img_src();
		}
		?>
		<tr class="form-field">
			<th scope="row" valign="top"><label><?php _e( 'Hover Thumbnail', 'woocommerce' ); ?></label></th>
			<td>
				<div id="product_cat_hover_thumbnail" style="float: left; margin-right: 10px;"><img src="<?php echo esc_url( $image ); ?>" width="60px" height="60px" /></div>
				<div style="line-height: 60px;">
					<input type="hidden" id="product_cat_hover_thumbnail_id" name="product_cat_hover_thumbnail_id" value="<?php echo $thumbnail_id; ?>" />
					<button type="button" class="hover_upload_image_button button"><?php _e( 'Upload/Add image', 'woocommerce' ); ?></button>
					<button type="button" class="hover_remove_image_button button"><?php _e( 'Remove image', 'woocommerce' ); ?></button>
				</div>
				<script type="text/javascript">

					// Only show the "remove image" button when needed
					if ( '0' === jQuery( '#product_cat_hover_thumbnail_id' ).val() ) {
						jQuery( '.hover_remove_image_button' ).hide();
					}

					// Uploading files
					var hover_file_frame;

					jQuery( document ).on( 'click', '.hover_upload_image_button', function( event ) {

						event.preventDefault();

						// If the media frame already exists, reopen it.
						if ( hover_file_frame ) {
							hover_file_frame.open();
							return;
						}

						// Create the media frame.
						hover_file_frame = wp.media.frames.downloadable_file = wp.media({
							title: '<?php _e( "Choose an image", "woocommerce" ); ?>',
							button: {
								text: '<?php _e( "Use image", "woocommerce" ); ?>'
							},
							multiple: false
						});

						// When an image is selected, run a callback.
						hover_file_frame.on( 'select', function() {
							var attachment = hover_file_frame.state().get( 'selection' ).first().toJSON();

							jQuery( '#product_cat_hover_thumbnail_id' ).val( attachment.id );
							jQuery( '#product_cat_hover_thumbnail' ).find( 'img' ).attr( 'src', attachment.sizes.thumbnail.url );
							jQuery( '.hover_remove_image_button' ).show();
						});

						// Finally, open the modal.
						hover_file_frame.open();
					});

					jQuery( document ).on( 'click', '.hover_remove_image_button', function() {
						jQuery( '#product_cat_hover_thumbnail' ).find( 'img' ).attr( 'src', '<?php echo esc_js( wc_placeholder_img_src() ); ?>' );
						jQuery( '#product_cat_hover_thumbnail_id' ).val( '' );
						jQuery( '.hover_remove_image_button' ).hide();
						return false;
					});

				</script>
				<div class="clear"></div>
			</td>
		</tr>
		<?php
}

/**
 * save_category_fields function.
 *
 * @param mixed $term_id Term ID being saved
 * @param mixed $tt_id
 * @param string $taxonomy
 */
function cloudfw_woocommerce_save_category_fields( $term_id, $tt_id = '', $taxonomy = '' ) {
	if ( isset( $_POST['product_cat_hover_thumbnail_id'] ) && 'product_cat' === $taxonomy ) {
		update_woocommerce_term_meta( $term_id, 'hover_thumbnail_id', absint( $_POST['product_cat_hover_thumbnail_id'] ) );
	}
}