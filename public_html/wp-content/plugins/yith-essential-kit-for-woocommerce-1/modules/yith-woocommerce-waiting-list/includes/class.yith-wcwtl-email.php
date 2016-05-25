<?php
/**
 * Email class
 *
 * @author Yithemes
 * @package YITH WooCommerce Waiting List
 * @version 1.0.0
 */

if ( ! defined( 'YITH_WCWTL' ) ) {
	exit;
} // Exit if accessed directly

if ( ! class_exists( 'YITH_WCWTL_Email' ) ) {
	/**
	 * Email Class
	 * Extend WC_Email to send mail to waitlist users
	 *
	 * @class   YITH_WCWTL_Email
	 * @extends  WC_Email
	 */
	class YITH_WCWTL_Email extends WC_Email {

		/**
		 * Constructor
		 *
		 * @author Francesco Licandro <francesco.licandro@yithemes.com>
		 */
		public function __construct() {

			$this->id           = YITH_WCWTL_META . '_mailout';
			$this->title        = __( 'YITH Waiting list', 'yith-woocommerce-waiting-list' );
			$this->description  = __( 'When a product is no more Out-of-Stock and it is In-Stock again, this email is sent to all users registered in the waiting list for that product.', 'yith-woocommerce-waiting-list' );

			$this->heading      = __( '{product_title} is now back in stock at {blogname}', 'yith-woocommerce-waiting-list' );
			$this->subject      = __( 'A product you are waiting for is back in stock', 'yith-woocommerce-waiting-list' );

			$this->template_base    = YITH_WCWTL_TEMPLATE_PATH . '/email/';
			$this->template_html    = 'yith-wcwtl-mail.php';
			$this->template_plain   = 'plain/yith-wcwtl-mail.php';

			// Triggers for this email
			add_action( 'send_yith_waitlist_mailout_notification', array( $this, 'trigger' ), 10, 2 );

			// Call parent constructor
			parent::__construct();
		}

		/**
		 * Trigger Function
		 *
		 * @access public
		 * @since 1.0.0
		 * @param mixed $users Waitlist users array
		 * @param integer $product_id Product id
		 * @return void
		 * @author Francesco Licandro <francesco.licandro@yithemes.com>
		 */
		public function trigger( $users, $product_id ) {

			$this->object = wc_get_product( $product_id );

			if( ! $this->object ) {
				return;
			}

			$this->find[]       = '{product_title}';
			$this->replace[]    = $this->object->get_title();

			$response = true;

			// add user to BCC
			$header = $this->get_headers() . 'BCC: '. implode(",", $users) . "\r\n";
			$response = $this->send( '', $this->get_subject(), $this->get_content(), $header, $this->get_attachments() );

			if( $response ) {
				add_filter( 'yith_wcwtl_send_mail_response', '__return_true' );
			}
		}

		/**
		 * get_content_html function.
		 *
		 * @access public
		 * @since 1.0.0
		 * @return string
		 * @author Francesco Licandro <francesco.licandro@yithemes.com>
		 */
		public function get_content_html() {
			ob_start();

			wc_get_template( $this->template_html, array(
						'product_title'   => $this->object->get_title(),
						'product_link'  => get_permalink( $this->object->id ),
						'email_heading' => $this->get_heading()
					), false, $this->template_base
			);

			return ob_get_clean();
		}

		/**
		 * get_content_plain function.
		 *
		 * @access public
		 * @since 1.0.0
		 * @return string
		 * @author Francesco Licandro <francesco.licandro@yithemes.com>
		 */
		public function get_content_plain() {
			ob_start();

			wc_get_template( $this->template_plain, array(
					'product_title'   => $this->object->get_title(),
					'product_link'  => get_permalink( $this->object->id ),
					'email_heading' => $this->get_heading()
				), false, $this->template_base
			);

			return ob_get_clean();
		}
	}

}

return new YITH_WCWTL_Email();
