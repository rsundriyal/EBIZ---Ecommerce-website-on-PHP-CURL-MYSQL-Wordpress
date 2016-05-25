<?php
/**
 * Frontend class
 *
 * @author Yithemes
 * @package YITH WooCommerce Recently Viewed Products
 * @version 1.0.0
 */

if ( ! defined( 'YITH_WRVP' ) ) {
	exit;
} // Exit if accessed directly

if ( ! class_exists( 'YITH_WRVP_Frontend' ) ) {
	/**
	 * Frontend class.
	 * The class manage all the frontend behaviors.
	 *
	 * @since 1.0.0
	 */
	class YITH_WRVP_Frontend {

		/**
		 * Single instance of the class
		 *
		 * @var \YITH_WRVP_Frontend
		 * @since 1.0.0
		 */
		protected static $instance;

		/**
		 * Plugin version
		 *
		 * @var string
		 * @since 1.0.0
		 */
		public $version = YITH_WRVP_VERSION;

		/**
		 * Product list
		 *
		 * @var array
		 * @since 1.0.0
		 */
		protected $_products_list = array();

		/**
		 * Current user id
		 *
		 * @var string
		 * @since 1.0.0
		 */
		protected $_user_id = '';

		/**
		 * The name of cookie name
		 *
		 * @var string
		 * @since 1.0.0
		 */
		protected $_cookie_name = '';

		/**
		 * The name of cookie name
		 *
		 * @var string
		 * @since 1.0.0
		 */
		protected $_meta_name = 'yith_wrvp_list';

		/**
		 * Returns single instance of the class
		 *
		 * @return \YITH_WRVP_Frontend
		 * @since 1.0.0
		 */
		public static function get_instance(){
			if( is_null( self::$instance ) ){
				self::$instance = new self();
			}

			return self::$instance;
		}

		/**
		 * Constructor
		 *
		 * @access public
		 * @since 1.0.0
		 */
		public function __construct() {

			$this->_user_id = get_current_user_id();

			// set cookie name based on user id
			$this->_cookie_name = 'yith_wrvp_list_' . $this->_user_id;

			// populate the list of products
			$this->_products_list = isset( $_COOKIE[ $this->_cookie_name ] ) ? unserialize( $_COOKIE[ $this->_cookie_name ] ) : array();

			add_shortcode( 'yith_similar_products', array( $this, 'similar_products' ) );

			add_action( 'template_redirect', array( $this, 'track_user_viewed_produts' ), 99 );

			add_action( 'woocommerce_after_single_product_summary', array( $this, 'print_shortcode' ), 30 );

		}

		/**
		 * Track user viewed products
		 *
		 * @access public
		 * @since 1.0.0
		 * @author Francesco Licandro
		 */
		public function track_user_viewed_produts(){

			global $post;

			if( is_null( $post ) || $post->post_type != 'product' )
				return;

			// if product is not already in list add
			if( ! in_array( $post->ID, $this->_products_list ) ) {

				$this->_products_list[] = $post->ID;

				$duration = get_option( 'yith-wrvp-cookie-time' );
				$duration = time() + (86400 * $duration);

				// set cookie
				setcookie( $this->_cookie_name, serialize( $this->_products_list ), $duration, COOKIEPATH, COOKIE_DOMAIN, false, true );
//
//				// if user also exists add meta with products list
//				if( $this->_user_id ) {
//					update_user_meta( $this->_user_id, $this->_meta_name, $this->_products_list );
//				}
			}
		}

		/**
		 * Get list of similar products based on user chronology
		 *
		 * @access public
		 * @since 1.0.0
		 * @author Francesco Licandro
		 */
		public function get_similar_product() {

			global $product, $wpdb;

			$cats_array = array();
			$tags_array = array();

			$excluded = array( 0 );
			if( $product ) {
				$excluded[] = $product->id;
			}

			foreach( $this->_products_list as $product_id ) {
				if( $product && $product_id == $product->id )
					continue; // exclude current products

				// get categories
				$categories = wp_get_post_terms( $product_id, 'product_cat' );

				foreach( $categories as $category ) {
					if( ! in_array( $category->term_id, $cats_array ) ) {
						$cats_array[] = intval( $category->term_id );
					}
				}

				// get tags
				$tags = wp_get_post_terms( $product_id, 'product_tag' );

				foreach( $tags as $tag ) {
					if( ! in_array( $tag->term_id, $tags_array ) ) {
						$tags_array[] = intval( $tag->term_id );
					}
				}
			}

			// return array() if cats and tags are empty
			if( empty( $cats_array ) && empty( $tags_array ) ) {
				return array();
			}

			$query = $this->build_query( $cats_array, $tags_array, $excluded );
			$products = $wpdb->get_col( implode( ' ', $query ) );

			return $products;

		}

		/**
		 * Query build for get similar products
		 *
		 * @access public
		 * @since 1.0.0
		 * @param $cats_array
		 * @param $tags_array
		 * @param $excluded
		 * @return array
		 * @author Francesco Licandro
		 */
		protected function build_query( $cats_array, $tags_array, $excluded ) {

			global $wpdb;

			$query           = array();
			$query['fields'] = "SELECT DISTINCT ID FROM {$wpdb->posts} p";
			$query['join']   = " INNER JOIN {$wpdb->postmeta} pm ON ( pm.post_id = p.ID AND pm.meta_key='_visibility' )";
			$query['join']  .= " INNER JOIN {$wpdb->term_relationships} tr ON (p.ID = tr.object_id)";
			$query['join']  .= " INNER JOIN {$wpdb->term_taxonomy} tt ON (tr.term_taxonomy_id = tt.term_taxonomy_id)";
			$query['join']  .= " INNER JOIN {$wpdb->terms} t ON (t.term_id = tt.term_id)";

			if ( get_option( 'yith-wrvp-hide-out-of-stock' ) === 'yes' ) {
				$query['join'] .= " INNER JOIN {$wpdb->postmeta} pm2 ON ( pm2.post_id = p.ID AND pm2.meta_key='_stock_status' )";
			}

			$query['where']  = " WHERE 1=1";
			$query['where'] .= " AND p.post_status = 'publish'";
			$query['where'] .= " AND p.post_type = 'product'";
			$query['where'] .= " AND p.ID NOT IN ( " . implode( ',', $excluded ) . " )";
			$query['where'] .= " AND pm.meta_value IN ( 'visible', 'catalog' )";

			if ( get_option( 'yith-wrvp-hide-out-of-stock' ) === 'yes' ) {
				$query['where'] .= " AND pm2.meta_value = 'instock'";
			}

			$rel = 'AND';
			if( ! empty( $cats_array ) ) {
				$query['where'] .= " AND ( tt.taxonomy = 'product_cat' AND t.term_id IN ( " . implode(',', $cats_array) . " ) )";
				$rel = 'OR';
			}
			if( ! empty( $tags_array ) ) {
				$query['where'] .= " {$rel} ( ( tt.taxonomy = 'product_tag' AND t.term_id IN ( " . implode(',', $tags_array) . " ) )";
				$query['where'] .= " AND p.ID NOT IN ( " . implode(',', $excluded) . " ) )";
			}

			return $query;
		}

		/**
		 * Shortcode similar products
		 *
		 * @access public
		 * @since 1.0.0
		 * @param mixed $atts
		 * @return mixed
		 * @author Francesco Licandro
		 */
		public function similar_products( $atts ) {

			extract( shortcode_atts(array(
				'posts_per_page' => get_option( 'yith-wrvp-num-products', '4' ),
				'orderby' => 'rand',
				'title'		=> get_option( 'yith-wrvp-section-title' )
			), $atts ) );

			$similar = $this->get_similar_product();

			if( empty( $similar ) ) {
				return '';
			}

			$args = apply_filters( 'yith_wrvp_similar_products_template_args', array(
				'post_type'            => 'product',
				'ignore_sticky_posts'  => 1,
				'no_found_rows'        => 1,
				'posts_per_page'       => $posts_per_page,
				'orderby'              => $orderby,
				'post__in'             => $similar
			) );

			$products = new WP_Query( $args );

			ob_start();

			if ( $products->have_posts() ) : ?>

				<div class="woocommerce yith-similar-products">

					<h2><?php echo $title ?></h2>

					<?php woocommerce_product_loop_start(); ?>

					<?php while ( $products->have_posts() ) : $products->the_post(); ?>

						<?php wc_get_template_part( 'content', 'product' ); ?>

					<?php endwhile; // end of the loop. ?>

					<?php woocommerce_product_loop_end(); ?>

				</div>

			<?php endif;

			$content = ob_get_clean();

			wp_reset_postdata();

			return $content;
		}

		/**
		 * Print shortcode similar products on single product page based on user viewed products
		 *
		 * @access public
		 * @since 1.0.0
		 * @author Francesco Licandro
		 */
		public function print_shortcode() {

			echo do_shortcode('[yith_similar_products]');
		}

	}
}
/**
 * Unique access to instance of YITH_WRVP_Frontend class
 *
 * @return \YITH_WRVP_Frontend
 * @since 1.0.0
 */
function YITH_WRVP_Frontend(){
	return YITH_WRVP_Frontend::get_instance();
}