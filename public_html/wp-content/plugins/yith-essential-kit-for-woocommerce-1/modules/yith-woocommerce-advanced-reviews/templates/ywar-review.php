<?php
/**
 * Advanced Review Template
 *
 * @author        Yithemes
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
global $YWAR_AdvancedReview;

$rating     = $YWAR_AdvancedReview->get_meta_value_rating( $review->ID );
$approved   = $YWAR_AdvancedReview->get_meta_value_approved( $review->ID );
$product_id = $YWAR_AdvancedReview->get_meta_value_product_id( $review->ID );
$review_date = mysql2date( get_option( 'date_format' ), $review->post_date );

$author = $YWAR_AdvancedReview->get_meta_value_author( $review->ID );
$user   = isset( $author["review_user_id"] ) ? get_userdata( $author["review_user_id"] ) : null;

if ( $user ) {
	$author_name = $user->display_name;
} else if ( isset( $author["review_user_id"] ) ) {
	$author_name = $author["review_author"];
} else {
	$author_name = __( 'Anonymous', 'yith-woocommerce-advanced-reviews' );
}

?>

<?php apply_filters( 'yith_advanced_reviews_before_review', $review ); ?>

<li itemprop="review" itemscope itemtype="http://schema.org/Review" id="li-comment-<?php echo $review->ID; ?>">

	<div id="comment-<?php echo $review->ID; ?>" class="comment_container">

		<?php if ( $user ):
			echo get_avatar( $user->ID, apply_filters( 'woocommerce_review_gravatar_size', '60' ), '', $user->user_email );
		else:
			echo get_avatar( $author["review_author_email"], apply_filters( 'woocommerce_review_gravatar_size', '60' ), '', $author["review_author_email"] );
		endif; ?>

		<div class="comment-text">

			<?php if ( $rating && get_option( 'woocommerce_enable_review_rating' ) == 'yes' ) : ?>

				<div itemprop="reviewRating" itemscope itemtype="http://schema.org/Rating" class="star-rating" title="<?php echo sprintf( __( 'Rated %d out of 5', 'yith-woocommerce-advanced-reviews' ), $rating ) ?>">
					<span style="width:<?php echo ( $rating / 5 ) * 100; ?>%"><strong
							itemprop="ratingValue"><?php echo $rating; ?></strong> <?php _e( 'out of 5', 'yith-woocommerce-advanced-reviews' ); ?></span>
				</div>

			<?php endif; ?>

			<?php if ( $approved == '0' ) : ?>

				<p class="meta"><em><?php _e( 'Your comment is waiting for approval', 'yith-woocommerce-advanced-reviews' ); ?></em></p>

			<?php else : ?>

				<p class="meta">
					<strong itemprop="author"><?php echo $author_name; ?></strong> <?php

					if ( $user && get_option( 'woocommerce_review_rating_verification_label' ) === 'yes' ) {
						if ( wc_customer_bought_product( $user->user_email, $user->ID, $product_id ) ) {
							echo '<em class="verified">(' . __( 'verified owner', 'yith-woocommerce-advanced-reviews' ) . ')</em> ';
						}
					}
					?>
					<time itemprop="datePublished"
					      datetime="<?php echo mysql2date( 'c', $review_date ); ?>"><?php echo $review_date; ?></time>
				</p>

			<?php endif; ?>

			<div itemprop="description" class="description">
				<p><?php echo apply_filters( 'yith_advanced_reviews_review_content', $review ); ?></p>
			</div>
		</div>
	</div>
</li>