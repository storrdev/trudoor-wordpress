<?php
/**
 * Review Comments Template
 *
 * Closing li is left out on purpose!.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/review.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woothemes.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $post;
$rating   = intval( get_comment_meta( $comment->comment_ID, 'rating', true ) );
$verified = wc_review_is_from_verified_owner( $comment->comment_ID );

?>
<li itemprop="review" itemscope itemtype="http://schema.org/Review" <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">

	<div id="comment-<?php comment_ID(); ?>" class="comment_container">

		<?php echo get_avatar( $comment, apply_filters( 'woocommerce_review_gravatar_size', '75' ), '' ); ?>

		<div class="comment-text ui--box ui--gradient ui--gradient-grey clearfix">

			<div class="meta ui--gradient ui--gradient-grey ui--gradient-grey-border-bottom clearfix">
				<div class="ui--comments-arrow"><i class="fontawesome-caret-left"></i></div>

				<div class="pull-left">
					<?php if ($GLOBALS['comment']->comment_approved == '0') : ?>
						<em><?php _e( 'Your comment is awaiting approval', 'woocommerce' ); ?></em>
					<?php else : ?>
							<strong itemprop="author" itemscope itemtype="http://schema.org/Person"><span itemprop="name"><?php comment_author(); ?></span></strong> <?php

								if ( get_option('woocommerce_review_rating_verification_label') == 'yes' )
									if ( woocommerce_customer_bought_product( $GLOBALS['comment']->comment_author_email, $GLOBALS['comment']->user_id, $post->ID ) )
										echo '<em class="verified">(' . __( 'verified owner', 'woocommerce' ) . ')</em> ';

							?><span class="dash">&ndash;</span> <small><time itemprop="datePublished" datetime="<?php echo get_comment_date('c'); ?>"><?php echo get_comment_date(__( get_option('date_format'), 'woocommerce' )); ?></time>:</small>

					<?php endif; ?>
				</div>

				<?php if ( get_option('woocommerce_enable_review_rating') == 'yes' ) : ?>


				<?php

					$rating = intval( get_comment_meta( $GLOBALS['comment']->comment_ID, 'rating', true ) );
					$average = ( $rating / 5 ) * 100;

					echo '

						<div itemprop="reviewRating" itemscope itemtype="http://schema.org/Rating" class="ui--star-rating-wrap pull-right" title="'. sprintf(__( 'Rated %d out of 5', 'woocommerce' ), $rating) .'">
							<div class="ui--star-rating-text"> <strong itemprop="ratingValue">'.$rating.'</strong> ' . __( 'out of 5', 'woocommerce' ) .'</div>
							<div class="ui--star-rating" title="'. sprintf(__( 'Rated %d out of 5', 'woocommerce' ), $rating) .'">
								<div class="ui--star-rating-background">
									<i class="ui--star icon fontawesome-star-empty"></i>
									<i class="ui--star icon fontawesome-star-empty"></i>
									<i class="ui--star icon fontawesome-star-empty"></i>
									<i class="ui--star icon fontawesome-star-empty"></i>
									<i class="ui--star icon fontawesome-star-empty"></i>
								</div>
								<div class="ui--star-rating-highlight" style="width:'. $average . '%">
									<i class="ui--star icon fontawesome-star"></i>
									<i class="ui--star icon fontawesome-star"></i>
									<i class="ui--star icon fontawesome-star"></i>
									<i class="ui--star icon fontawesome-star"></i>
									<i class="ui--star icon fontawesome-star"></i>
								</div>
							</div>
						</div>

					';

				 ?>

				<?php endif; ?>

				<div class="pull-right">
	                <?php
		               //echo get_comment_reply_link( array( 'reply_text' =>  __( 'reply', 'cloudfw' ), 'depth' => 1, 'max_depth' => 2 ) );
		               // edit_comment_link( __( 'edit', 'cloudfw' ), ' · ' );
	                 ?>
				</div>

			</div>

				<div itemprop="reviewBody" class="description"><?php comment_text(); ?></div>
				<div class="clear"></div>
			</div>
		<div class="clear"></div>
	</div>
