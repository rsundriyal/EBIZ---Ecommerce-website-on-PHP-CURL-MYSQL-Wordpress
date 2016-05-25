<?php
/*
 * This file belongs to the YIT Framework.
 *
 * This source file is subject to the GNU GENERAL PUBLIC LICENSE (GPL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.gnu.org/licenses/gpl-3.0.txt
 */
if ( ! defined( 'YITH_WPV_VERSION' ) ) {
    exit( 'Direct access forbidden.' );
}

if ( ! class_exists( 'YITH_Commissions' ) ) {
    /**
     * Class YITH_Commissions
     *
     * @class      YITH_Commissions
     * @package    Yithemes
     * @since      Version 2.0.0
     * @author     Your Inspiration Themes
     */
    class YITH_Commissions {

        /**
         * Whether or not to show order item meta added by plugin in order page
         *
         * @var bool Whether or not to show order item meta
         *
         * @since 1.0
         */
        public $show_order_item_meta = true;

        /**
         * Plugin version
         *
         * @var string
         * @since 1.0
         */
        public $version = YITH_WPV_VERSION;

        /**
         * Commission page screen
         *
         * @var string
         * @since 1.0
         */
        protected $_screen = 'yith_vendor_commissions';

        /**
         * Main Instance
         *
         * @var string
         * @since 1.0
         * @access protected
         */
        protected static $_instance = null;

        /**
         * Commission table name
         *
         * @var string
         * @since 1.0
         * @access protected
         */
        protected static $_commissions_table_name = 'yith_vendors_commissions';

        /**
         * Commission notes table name
         *
         * @var string
         * @since 1.0
         * @access protected
         */
        protected static $_commissions_notes_table_name = 'yith_vendors_commissions_notes';

        /**
         * Payments table name
         *
         * @var string
         * @since 1.0
         * @access protected
         */
        protected static $_payments_table_name = 'yith_vendors_payments';

        /**
         * Payments relationship table name
         *
         * @var string
         * @since 1.0
         * @access protected
         */
        protected static $_payments_relationship_table_name = 'yith_vendors_payments_relathionship';

	    /**
	     * Admin notice messages
	     *
	     * @var array
	     * @since 1.0
	     */
	    protected $_messages = array();

        /**
         * Database version
         *
         * @var string
         * @since 1.0
         * @access protected
         */
        protected static $_db_version = YITH_WPV_DB_VERSION;

        /**
         * Status changing capabilities
         *
         * @var array
         * @since 1.0
         * @access protected
         */
        protected $_status_capabilities = array(
            'pending'    => array( 'unpaid', 'paid', 'cancelled' ),
            'unpaid'     => array( 'pending', 'paid', 'cancelled', 'processing' ),
            'paid'       => array( 'pending', 'unpaid', 'refunded' ),
            'cancelled'  => array(),
            'refunded'   => array(),
            'processing' => array( 'paid', 'unpaid', 'cancelled' ),
        );

        /**
         * Main plugin Instance
         *
         * @static
         * @return YITH_Commissions Main instance
         *
         * @since  1.0
         * @author Andrea Grillo <andrea.grillo@yithemes.com>
         */
        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        /**
         * Constructor
         *
         * @author Andrea Grillo <andrea.grillo@yithemes.com>
         * @return mixed|YITH_Commissions
         * @since  1.0.0
         * @access public
         */
        public function __construct() {
	        add_action( 'init', array( $this, 'add_commissions_table_wpdb' ), 0 );
	        add_action( 'switch_blog', array( $this, 'add_commissions_table_wpdb' ), 0 );

            add_action( 'yith_wcmv_checkout_order_processed', array( $this, 'register_commissions' ), 10, 1 );
            add_action( 'woocommerce_order_status_changed', array( $this, 'manage_status_changing' ), 10, 3 );
            add_action( 'woocommerce_refund_created', array( $this, 'register_commission_refund' ) );
            add_action( 'before_delete_post', array( $this, 'remove_refund_commission_helper' ) );
            add_action( 'deleted_post', array( $this, 'remove_refund_commission' ) );

            $this->_admin_init();
        }
        /**
         * Admin init
         */
        protected function _admin_init() {
            if ( ! is_admin() ) {
                return;
            }

            add_action( 'admin_menu', array( $this, 'add_menu_item' ) );
	        add_filter( 'admin_title', array( $this, 'change_commission_view_page_title' ), 10, 2 );

            add_filter( 'woocommerce_screen_ids', array( $this, 'add_screen_ids' ) );

	        add_action( 'current_screen', array( $this, 'add_screen_option' ) );
	        add_filter( 'set-screen-option', array( $this, 'set_screen_option' ), 10, 3 );
	        add_action( 'admin_notices', array( $this, 'admin_notice' ) );

	        /* == Update commission status from Commissions Page == */
	        add_action( 'admin_action_yith_commission_table_actions', array( $this, 'table_update_status' ) );

	        //Set messages
	        $this->_messages = apply_filters( 'yith_commissions_admin_notice',
		        array(
			        'error'   => __( 'Commission status not updated!', 'yith_wc_product_vendors' ),
			        'updated' => __( 'Commission status updated!', 'yith_wc_product_vendors' ),
			        'pay-process' => __( 'Payment successful. In a few minutes you will receive an email with the outcome of the payment and the commission state will be changed accordingly.', 'yith_wc_product_vendors' ),
			        'pay-failed'  => __( 'Payment failed.', 'yith_wc_product_vendors' )
		        )
	        );

            add_filter( 'woocommerce_attribute_label', array( $this, 'commissions_attribute_label' ), 10, 3 );
        }

        /**
         * Return the screen id for commissions page
         *
         * @since 1.0
         */
        public function get_screen() {
            return $this->_screen;
        }

        /**
         * Define the list of status
         *
         * @since 1.0
         */
        public function get_status() {

            /**
             * WC Order Status Icon  ->  YITH Commissions Status
             * pending               ->  pending
             * processing            ->  pending
             * on-hold               ->  unpaid
             * completed             ->  paid
             * cancelled             ->  cancelled
             * failed                ->  cancelled
             * refunded              ->  refunded
             *
             */
            return array(
                'paid'       => __( 'Paid', 'yith_wc_product_vendors' ),
                'unpaid'     => __( 'Unpaid', 'yith_wc_product_vendors' ),
                'pending'    => __( 'Pending', 'yith_wc_product_vendors' ),
                'refunded'   => __( 'Refunded', 'yith_wc_product_vendors' ),
                'cancelled'  => __( 'Cancelled', 'yith_wc_product_vendors' ),
                'processing' => __( 'Processing', 'yith_wc_product_vendors' ),
            );
        }

	    /**
	     * Print admin notice
	     *
	     * @since  1.0
	     * @author Andrea Grillo <andrea.grillo@yithemes.com>
	     *
	     * @fire yith_commissions_admin_notice hooks
	     */
	    public function admin_notice() {
		    if ( ! empty( $_GET['message'] ) && ! empty( $_GET['page'] ) && $this->get_screen() == $_GET['page'] && isset( $this->_messages[ $_GET['message'] ] ) ) {
			    $type = $_GET['message'];
			    if ( in_array( $type, array( 'pay-process' ) ) ) {
				    $type = 'update-nag';
			    } else if( in_array( $type, array( 'pay-failed' ) ) ) {
                    $type = 'error';
                }

                $text    = ! empty( $_GET['text'] ) ? sanitize_text_field( $_GET['text'] ) : '';
			    $message = in_array( $type, array( 'updated', 'error' ) ) ? '<p>' . $this->_messages[ $_GET['message'] ] . ' ' . $text . '</p>' : $this->_messages[ $_GET['message'] ] . ' ' . $text;
			    ?>
			    <div class="<?php echo $type ?>">
				    <?php echo $message ?>
			    </div>
		    <?php
		    }
	    }

        /**
         * Check for status changing
         *
         * @param $new_status
         * @param $old_status
         *
         * @return bool
         */
        public function is_status_changing_permitted( $new_status, $old_status ) {
            return $new_status != $old_status && in_array( $new_status, $this->_status_capabilities[$old_status] );
        }

        /**
         * Add the Commissions menu item in dashboard menu
         *
         * @author Andrea Grillo <andrea.grillo@yithemes.com>
         * @since  1.0
         * @return void
         * @fire yith_wc_product_vendors_commissions_menu_items hooks
         * @see    wp-admin\includes\plugin.php -> add_menu_page()
         */
        public function add_menu_item() {
            $vendor = yith_get_vendor( 'current', 'user' );
            $is_super_user = $vendor->is_super_user();

            if( $is_super_user || $vendor->is_valid() && $vendor->has_limited_access() && $vendor->is_owner() ) {

                $args = apply_filters( 'yith_wc_product_vendors_commissions_menu_items', array(
                        'page_title' => __( 'Commissions', 'yith_wc_product_vendors' ),
                        'menu_title' => __( 'Commissions', 'yith_wc_product_vendors' ),
                        'capability' => 'edit_products',
                        'menu_slug'  => $this->_screen,
                        'function'   => array( $this, 'commissions_details_page' ),
                        'icon'       => 'dashicons-tickets',
                        'position'   => 58 /* After WC Products */
                    )
                );

                extract( $args );

                add_menu_page( $page_title, $menu_title, $capability, $menu_slug, $function, $icon, $position );
            }

//            if ( $is_super_user  ) {
//                add_submenu_page( $this->_screen, $page_title, __( 'Commissions report', 'yith_wc_product_vendors' ), $capability, $menu_slug );
//
//                $submenu_args = apply_filters( 'yith_wc_product_vendors_commissions_submenu_items', array(
//                        'parent_slug' => $this->_screen,
//                        'page_title'  => __( 'Unpaid earnings', 'yith_wc_product_vendors' ),
//                        'menu_title'  => __( 'Unpaid earnings', 'yith_wc_product_vendors' ),
//                        'capability'  => 'manage_options',
//                        'menu_slug'   => 'yith_commissions_by_vendor',
//                        'function'    => array( $this, 'earnings_by_vendor' )
//                    )
//                );
//
//                extract( $submenu_args );
//
//                add_submenu_page( $parent_slug, $page_title, $menu_title, $capability, $menu_slug, $function );
//            }
        }

        /**
         * Show the Commissions page
         *
         * @author Andrea Grillo <andrea.grillo@yithemes.com>
         * @since  1.0
         * @return void
         * @fire yith_vendors_commissions_template hooks
         */
        public function commissions_details_page() {
	        if ( isset( $_GET['view'] ) ) {
		        $commission = YITH_Commission( absint( $_GET['view'] ) );
		        $args = apply_filters( 'yith_vendors_commission_view_template', array( 'commission' => $commission ) );
		        yith_wcpv_get_template( 'commission-view', $args, 'admin' );
	        }
	        else {
		        if ( ! class_exists( 'WP_List_Table' ) ) {
			        require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
		        }

		        $path_class = YITH_WPV_PATH . 'includes/lib/class.yith-commissions-list-table';
		        $class = 'YITH_Commissions_List_Table';

		        require_once( $path_class . '.php' );
		        if ( file_exists( $path_class . '-premium.php' ) ) {
			        require_once( $path_class . '-premium.php' );
			        $class .= '_Premium';
		        }

		        /** @var YITH_Commissions_List_Table|YITH_Commissions_List_Table_Premium $commissions_table */
		        $commissions_table = new $class();
		        $commissions_table->prepare_items();

                $args = apply_filters( 'yith_vendors_commissions_template', array(
                        'commissions_table' => $commissions_table,
                        'page_title'        => __( 'Vendor Commissions', 'yith_wc_product_vendors' )
                    )
                );

		        yith_wcpv_get_template( 'commissions', $args, 'admin' );
	        }
        }

        /**
         * Show the Commissions page
         *
         * @author Andrea Grillo <andrea.grillo@yithemes.com>
         * @since  1.8.4
         * @return void
         * @fire yith_vendors_commissions_template hooks
         */
        public function earnings_by_vendor() {
            if ( ! class_exists( 'WP_List_Table' ) ) {
                require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
            }

            $path_class = YITH_WPV_PATH . 'includes/lib/class.yith-commissions-earnings-by-vendor-table';
            $class = 'YITH_Commissions_Earnings_By_Vendor_Table';

            require_once( $path_class . '.php' );

            if ( file_exists( $path_class . '-premium.php' ) ) {
                require_once( $path_class . '-premium.php' );
                $class .= '_Premium';
            }

            /** @var YITH_Commissions_List_Table|YITH_Commissions_List_Table_Premium $commissions_table */
            $commissions_table = new $class();
            $commissions_table->prepare_items();

            $args = apply_filters( 'yith_vendors_commissions_template', array(
                    'commissions_table' => $commissions_table,
                    'page_title'        => __( 'Earnings by vendor', 'yith_wc_product_vendors' )
                )
            );

            yith_wcpv_get_template( 'commissions', $args, 'admin' );
        }

	    /**
	     * Change the page title of commission detail page
	     *
	     * @param $admin_title
	     * @param $title
	     *
	     * @return string
	     * @since 1.0
	     */
	    public function change_commission_view_page_title( $admin_title, $title ) {
		    if ( isset( $_GET['page'] ) && $_GET['page'] == $this->_screen && ! empty( $_GET['view'] ) ) {
			    $title = sprintf( __( 'Commission #%d details', 'yith_wc_product_vendors' ), absint( $_GET['view'] ) );
			    $admin_title = sprintf( __( '%1$s &lsaquo; %2$s &#8212; WordPress' ), $title, get_bloginfo( 'name' ) );
		    }

		    return $admin_title;
	    }

        /**
         * Create the {$wpdb->prefix}_yith_vendor_commissions table
         *
         * @author Andrea Grillo <andrea.grillo@yithemes.com>
         * @since  1.0
         * @return void
         * @see    dbDelta()
         */
        public static function create_commissions_table() {

            /**
             * If exists yith_product_vendors_db_version option return null
             */
            if ( get_option( 'yith_product_vendors_db_version' ) ) {
                return;
            }

	        /**
	         * Check if dbDelta() exists
	         */
	        if ( ! function_exists( 'dbDelta' ) ) {
		        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	        }

            global $wpdb;
	        $charset_collate = $wpdb->get_charset_collate();

            $table_name = $wpdb->prefix . self::$_commissions_table_name;
            $create = "CREATE TABLE IF NOT EXISTS $table_name (
                        ID bigint(20) NOT NULL AUTO_INCREMENT,
                        order_id bigint(20) NOT NULL,
                        user_id bigint(20) NOT NULL,
                        vendor_id bigint(20) NOT NULL,
                        line_item_id bigint(20) NOT NULL,
                        rate decimal(5,4) NOT NULL,
                        amount double(15,4) NOT NULL,
                        status varchar(100) NOT NULL,
                        last_edit DATETIME NOT NULL DEFAULT '000-00-00 00:00:00',
                        last_edit_gmt DATETIME NOT NULL DEFAULT '000-00-00 00:00:00',
                        PRIMARY KEY (ID)
                        ) $charset_collate;";
            dbDelta( $create );

            $table_name = $wpdb->prefix . self::$_commissions_notes_table_name;
            $create = "CREATE TABLE IF NOT EXISTS $table_name (
                        ID bigint(20) NOT NULL AUTO_INCREMENT,
                        commission_id bigint(20) NOT NULL,
                        note_date DATETIME NOT NULL DEFAULT '000-00-00 00:00:00',
                        description TEXT,
                        PRIMARY KEY (ID)
                        ) $charset_collate;";
            dbDelta( $create );

            self::create_transaction_table();

            add_option( 'yith_product_vendors_db_version', self::$_db_version );
        }

        /**
         * Create the {$wpdb->prefix}_yith_vendor_commissions table
         *
         * @author Andrea Grillo <andrea.grillo@yithemes.com>
         * @since  1.0
         * @return void
         * @see    dbDelta()
         */
        public static function create_transaction_table() {

            /**
             * Check if dbDelta() exists
             */
            if ( ! function_exists( 'dbDelta' ) ) {
                require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
            }

            global $wpdb;
            $charset_collate = $wpdb->get_charset_collate();

            $table_name = $wpdb->prefix . self::$_payments_table_name;
            $create = "CREATE TABLE IF NOT EXISTS $table_name (
                        ID bigint(20) NOT NULL AUTO_INCREMENT,
                        vendor_id bigint(20) NOT NULL,
                        user_id bigint(20) NOT NULL,
                        amount double(15,4) NOT NULL,
                        status varchar(100) NOT NULL,
                        payment_date DATETIME NOT NULL DEFAULT '000-00-00 00:00:00',
                        payment_date_gmt DATETIME NOT NULL DEFAULT '000-00-00 00:00:00',
                        PRIMARY KEY (ID)
                        ) $charset_collate;";
            dbDelta( $create );

            $table_name = $wpdb->prefix . self::$_payments_relationship_table_name;
            $create = "CREATE TABLE IF NOT EXISTS $table_name (
                        ID bigint(20) NOT NULL AUTO_INCREMENT,
                        payment_id bigint(20) NOT NULL,
                        commission_id bigint(20) NOT NULL,
                        PRIMARY KEY (ID)
                        ) $charset_collate;";
            dbDelta( $create );
        }

        /**
         * Commissions API - set table name
         *
         * @author Andrea Grillo <andrea.grillo@yithemes.com>
         * @since  1.0
         * @return void
         */
        public function add_commissions_table_wpdb() {
            global $wpdb;
            $wpdb->commissions           = $wpdb->prefix . self::$_commissions_table_name;
            $wpdb->tables[]              = self::$_commissions_table_name;
            $wpdb->commissions_notes     = $wpdb->prefix . self::$_commissions_notes_table_name;
            $wpdb->tables[]              = self::$_commissions_notes_table_name;
            $wpdb->payments              = $wpdb->prefix . self::$_payments_table_name;
            $wpdb->tables[]              = self::$_payments_table_name;
            $wpdb->payments_relationship = $wpdb->prefix . self::$_payments_relationship_table_name;
            $wpdb->tables[]              = self::$_payments_relationship_table_name;
        }

        /**
         * Get Commissions
         *
         * @param array $q
         *
         * @return array
         * @author Andrea Grillo <andrea.grillo@yithemes.com>
         * @since  1.0
         */
        public function get_commissions( $q = array() ) {
            global $wpdb;

            $default_args = array(
                'line_item_id' => 0,
                'product_id'   => 0,
                'order_id'     => 0,
                'user_id'      => 0,
                'vendor_id'    => 0,
                'status'       => 'unpaid',
                'm'            => false,
                'date_query'   => false,
	            's'            => '',
                'number'       => '',
                'offset'       => '',
                'paged'        => '',
	            'orderby'      => 'ID',
	            'order'        => 'ASC',
                'fields'       => 'ids'
            );

	        foreach ( array( 'order_id', 'vendor_id', 'status', 'paged', 'm', 's', 'orderby', 'order', 'product_id' ) as $key ) {
		        if ( isset( $_REQUEST[ $key ] ) ) {
			        $default_args[ $key ] = $_REQUEST[ $key ];
		        }
	        }
            $q = wp_parse_args( $q, $default_args );

	        // Fairly insane upper bound for search string lengths.
	        if ( ! is_scalar( $q['s'] ) || ( ! empty( $q['s'] ) && strlen( $q['s'] ) > 1600 ) ) {
		        $q['s'] = '';
	        }

	        // First let's clear some variables
	        $where = '';
	        $limits = '';
	        $join = '';
	        $groupby = '';
	        $orderby = '';

            // query parts initializating
            $pieces = array( 'where', 'groupby', 'join', 'orderby', 'limits' );

            // filter
            if ( ! empty( $q['line_item_id'] ) ) {
                $where .= $wpdb->prepare( " AND c.line_item_id = %d", $q['line_item_id'] );
            }
            if ( ! empty( $q['product_id'] ) ) {
		        $join .= " JOIN {$wpdb->prefix}woocommerce_order_items oi ON ( oi.order_item_id = c.line_item_id AND oi.order_id = c.order_id )";
		        $join .= " JOIN {$wpdb->prefix}woocommerce_order_itemmeta oim ON ( oim.order_item_id = oi.order_item_id )";
                $where .= $wpdb->prepare( " AND oim.meta_key = %s AND oim.meta_value = %s", '_product_id', $q['product_id'] );
            }
            if ( ! empty( $q['order_id'] ) ) {
                $where .= $wpdb->prepare( " AND c.order_id = %d", $q['order_id'] );
            }
            if ( ! empty( $q['user_id'] ) ) {
                $where .= $wpdb->prepare( " AND c.user_id = %d", $q['user_id'] );
            }
            if ( ! empty( $q['vendor_id'] ) ) {
                $where .= $wpdb->prepare( " AND c.vendor_id = %d", $q['vendor_id'] );
            }
            if ( ! empty( $q['status'] ) && 'all' != $q['status'] ) {
	            if ( is_array( $q['status'] ) ) {
		            $q['status'] = implode( "', '", $q['status'] );
	            }
                $where .= sprintf( " AND c.status IN ( '%s' )", $q['status'] );
            }

	        // The "m" parameter is meant for months but accepts datetimes of varying specificity
	        if ( $q['m'] ) {
		        $q['m'] = absint( preg_replace( '|[^0-9]|', '', $q['m'] ) );

		        $join .= strpos( $join, "$wpdb->posts o" ) === false ? " JOIN $wpdb->posts o ON o.ID = c.order_id" : '';
		        $where .= " AND o.post_type = 'shop_order'";

		        $where .= " AND YEAR(o.post_date)=" . substr($q['m'], 0, 4);
		        if ( strlen($q['m']) > 5 )
			        $where .= " AND MONTH(o.post_date)=" . substr($q['m'], 4, 2);
		        if ( strlen($q['m']) > 7 )
			        $where .= " AND DAYOFMONTH(o.post_date)=" . substr($q['m'], 6, 2);
		        if ( strlen($q['m']) > 9 )
			        $where .= " AND HOUR(o.post_date)=" . substr($q['m'], 8, 2);
		        if ( strlen($q['m']) > 11 )
			        $where .= " AND MINUTE(o.post_date)=" . substr($q['m'], 10, 2);
		        if ( strlen($q['m']) > 13 )
			        $where .= " AND SECOND(o.post_date)=" . substr($q['m'], 12, 2);
	        }

            // Handle complex date queries
            if ( ! empty( $q['date_query'] ) ) {
                $join .= strpos( $join, "$wpdb->posts o" ) === false ? " JOIN $wpdb->posts o ON o.ID = c.order_id" : '';
		        $where .= " AND o.post_type = 'shop_order'";

                $date_query = new WP_Date_Query( $q['date_query'], 'o.post_date' );
                $where .= $date_query->get_sql();
            }

	        // Search
	        if ( $q['s'] ) {
		        // added slashes screw with quote grouping when done early, so done later
		        $q['s'] = stripslashes( $q['s'] );
		        // there are no line breaks in <input /> fields
		        $q['s'] = str_replace( array( "\r", "\n" ), '', $q['s'] );

		        // order
		        $join .= strpos( $join, "$wpdb->posts o" ) === false ? " JOIN $wpdb->posts o ON o.ID = c.order_id" : '';

		        // product
		        $join .= strpos( $join, 'woocommerce_order_items' ) === false ? " JOIN {$wpdb->prefix}woocommerce_order_items oi ON ( oi.order_item_id = c.line_item_id AND oi.order_id = c.order_id )" : '';
		        $where .= " AND oi.order_item_type = 'line_item'";

		        // user
		        $join .= " JOIN $wpdb->users u ON u.ID = c.user_id";
		        $join .= " JOIN $wpdb->usermeta um ON um.user_id = c.user_id";
		        $join .= " JOIN $wpdb->usermeta um2 ON um2.user_id = c.user_id";
		        $where .= " AND um.meta_key = 'first_name'";
		        $where .= " AND um2.meta_key = 'last_name'";

		        $s = array(
			        // search by order
			        $wpdb->prepare( "o.ID = %s", $q['s'] ),
			        // search by product
		            $wpdb->prepare( "oi.order_item_name LIKE %s", "%{$q['s']}%" ),
			        // search by username
		            $wpdb->prepare( "u.user_login LIKE %s", "%{$q['s']}%" ),
		            $wpdb->prepare( "u.user_nicename LIKE %s", "%{$q['s']}%" ),
		            $wpdb->prepare( "u.user_email LIKE %s", "%{$q['s']}%" ),
		            $wpdb->prepare( "um.meta_value LIKE %s", "%{$q['s']}%" ),
		            $wpdb->prepare( "um2.meta_value LIKE %s", "%{$q['s']}%" ),
		        );

		        $where .= ' AND ( ' . implode( ' OR ', $s ) . ' )';
	        }

	        // Order
	        if ( ! is_string( $q['order'] ) || empty( $q['order'] ) ) {
		        $q['order'] = 'DESC';
	        }

	        if ( 'ASC' === strtoupper( $q['order'] ) ) {
		        $q['order'] = 'ASC';
	        } else {
		        $q['order'] = 'DESC';
	        }

	        // Order by.
	        if ( empty( $q['orderby'] ) ) {
		        /*
				 * Boolean false or empty array blanks out ORDER BY,
				 * while leaving the value unset or otherwise empty sets the default.
				 */
		        if ( isset( $q['orderby'] ) && ( is_array( $q['orderby'] ) || false === $q['orderby'] ) ) {
			        $orderby = '';
		        } else {
			        $orderby = "c.ID " . $q['order'];
		        }
	        } elseif ( 'none' == $q['orderby'] ) {
		        $orderby = '';
	        } else {
		        $orderby_array = array();
		        if ( is_array( $q['orderby'] ) ) {
			        foreach ( $q['orderby'] as $_orderby => $order ) {
				        $orderby = addslashes_gpc( urldecode( $_orderby ) );

				        if ( ! is_string( $order ) || empty( $order ) ) {
					        $order = 'DESC';
				        }

				        if ( 'ASC' === strtoupper( $order ) ) {
					        $order = 'ASC';
				        } else {
					        $order = 'DESC';
				        }

				        $orderby_array[] = $orderby . ' ' . $order;
			        }
			        $orderby = implode( ', ', $orderby_array );

		        } else {
			        $q['orderby'] = urldecode( $q['orderby'] );
			        $q['orderby'] = addslashes_gpc( $q['orderby'] );

			        foreach ( explode( ' ', $q['orderby'] ) as $i => $orderby ) {
				        $orderby_array[] = $orderby;
			        }
			        $orderby = implode( ' ' . $q['order'] . ', ', $orderby_array );

			        if ( empty( $orderby ) ) {
				        $orderby = "c.ID " . $q['order'];
			        } elseif ( ! empty( $q['order'] ) ) {
				        $orderby .= " {$q['order']}";
			        }
		        }
	        }

	        // Paging
	        if ( ! empty($q['paged']) && ! empty($q['number']) ) {
		        $page = absint($q['paged']);
		        if ( !$page )
			        $page = 1;

                if ( empty( $q['offset'] ) ) {
                    $pgstrt = absint( ( $page - 1 ) * $q['number'] ) . ', ';
                }
                else { // we're ignoring $page and using 'offset'
                    $q['offset'] = absint( $q['offset'] );
                    $pgstrt      = $q['offset'] . ', ';
                }
                $limits = 'LIMIT ' . $pgstrt . $q['number'];
            }

            $clauses = compact( $pieces );

            $where   = isset( $clauses['where'] ) ? $clauses['where'] : '';
            $groupby = isset( $clauses['groupby'] ) ? $clauses['groupby'] : '';
            $join    = isset( $clauses['join'] ) ? $clauses['join'] : '';
            $orderby = isset( $clauses['orderby'] ) ? $clauses['orderby'] : '';
            $limits  = isset( $clauses['limits'] ) ? $clauses['limits'] : '';

	        if ( ! empty($groupby) )
		        $groupby = 'GROUP BY ' . $groupby;
	        if ( !empty( $orderby ) )
		        $orderby = 'ORDER BY ' . $orderby;

            $found_rows = '';
            if ( ! empty( $limits ) ) {
                $found_rows = 'SQL_CALC_FOUND_ROWS';
            }

            $fields = 'c.ID';

            if( 'count' != $q['fields'] && 'ids' != $q['fields'] ){
                if( is_array( $q['fields'] ) ){
                    $fields = implode( ',', $q['fields'] );
                }

                else {
                    $fields = $q['fields'];
                }
            }

            $res = $wpdb->get_col( "SELECT $found_rows DISTINCT $fields FROM $wpdb->commissions c $join WHERE 1=1 $where $groupby $orderby $limits" );

            // return count
            if ( 'count' == $q['fields'] ) {
	            return ! empty( $limits ) ? $wpdb->get_var( 'SELECT FOUND_ROWS()' ) : count( $res );
            }

            return $res;
        }

        /**
         * Return the count of posts in base of query
         *
         * @param array $q
         *
         * @return int
         * @since 1.0
         */
        public function count_commissions( $q = array() ) {
	        if ( 'last-query' == $q ) {
		        global $wpdb;
		        return $wpdb->get_var( 'SELECT FOUND_ROWS()' );
	        }

            $q['fields'] = 'count';
            return $this->get_commissions( $q );
        }

        /**
         * Register the commission linked to order
         *
         * @param $order_id int The order ID
         * @param $posted   array The value request
         *
         * @since 1.0
         */
        public function register_commissions( $order_id ) {

            // Only process commissions once
            $processed = get_post_meta( $order_id, '_commissions_processed', true );
            if ( $processed && $processed == 'yes' ) {
                return;
            }

            $order = wc_get_order( $order_id );

            // check all items of order to know if there is some vendor to credit and what are the products to process
            foreach ( $order->get_items() as $item_id => $item ) {
                $_product = $order->get_product_from_item( $item );
                $vendor   = yith_get_vendor( $_product, 'product' );

                if ( $vendor->is_valid() ) {

                    // calculate amount
                    $amount = $this->calculate_commission( $vendor, $order, $item );

                    // no amount to apply
                    if ( empty( $amount ) ) {
                        continue;
                    }

                    $args = array(
                        'line_item_id' => $item_id,
                        'order_id'     => $order->id,
                        'user_id'      => $vendor->get_owner(),
                        'vendor_id'    => $vendor->id,
                        'amount'       => $amount
                    );

                    // get commission from product if exists
                    if ( ! empty( $_product->product_commission ) ) {
                        $args['rate'] = (float) $_product->product_commission / 100;
                    }

                    // add commission in pending
                    $commission_id = YITH_Commission()->add( $args );

                    // add line item to retrieve simply the commission associated (parent order)
                    wc_add_order_item_meta( $item_id, '_commission_id', $commission_id );

                    do_action( 'yith_wcmv_after_single_register_commission', $commission_id, $item_id, '_commission_id', $order );
                }
            }

            // Mark commissions as processed
            update_post_meta( $order_id, '_commissions_processed', 'yes' );

            do_action( 'yith_commissions_processed', $order_id );
        }

        /**
         * Calculate commission for an order, vendor and item
         *
         * @param $vendor YITH_Vendor
         * @param $order  WC_Order
         * @param $item   array
         *
         * @return mixed
         */
        public function calculate_commission( $vendor, $order, $item ) {

            //check for product commission
            $_product = $order->get_product_from_item( $item );

            // Get percentage for commission
            $commission = ! empty( $_product->product_commission ) ? (float) $_product->product_commission / 100 : (float) $vendor->get_commission();

            // If commission is 0% then go no further
            if ( ! $commission ) {
                return 0;
            }

            // Check
            $get_item_amount = 'yes' == get_option( 'yith_wpv_include_coupon' ) ? 'get_item_total' : 'get_item_subtotal';

            // Get item amount params
            $include_tax = apply_filters( 'yith_wcmv_include_tax_in_commissions', 'no' == get_option( 'yith_wpv_include_tax', 'no' ) ? false : true );

            // Retrieve the real amount of single item, with right discounts applied and without taxes
            $line_total = (float) $order->$get_item_amount( $item, $include_tax, false ) * $item['qty'];

            // If total is 0 after discounts then go no further
            if ( ! $line_total ) {
                return 0;
            }

            // Get total amount for commission
            $amount = (float) $line_total * $commission;

            // If commission amount is 0 then go no further
            if ( ! $amount ) {
                return 0;
            }

            return $amount;
        }

        /**
         * Manage the status changing
         *
         * @param $order_id
         * @param $old_status
         * @param $new_status
         *
         * @since 1.0
         */
        public function manage_status_changing( $order_id, $old_status, $new_status ) {
            switch ( $new_status ) {

                case 'completed' :
                    $this->register_commissions_unpaid( $order_id );
                    break;

                case 'refunded' :
                    $this->register_commissions_refunded( $order_id );
                    break;

                case 'cancelled' :
                case 'failed' :
                    $this->register_commissions_cancelled( $order_id );
                    break;

                case 'pending':
                case 'on-hold':
                    $this->register_commissions_pending( $order_id );
                    break;

            }
        }

        /**
         * Register the commission as unpaid when the order is completed
         *
         * @param $order_id
         *
         * @since 1.0
         */
        public function register_commissions_unpaid( $order_id ) {

            // Ensure the order have commissions processed
            $processed = get_post_meta( $order_id, '_commissions_processed', true );
            if ( $processed && $processed == 'yes' ) {
                $order = wc_get_order( $order_id );

                foreach ( $order->get_items() as $item_id => $item ) {
                    if ( empty( $item['commission_id'] ) ) {
                        continue;
                    }

                    // retrieve commission
                    $commission = YITH_Commission( intval( $item['commission_id'] ) );

                    // set commission as unpaid, ready to be paid
                    $commission->update_status( 'unpaid' );
	                $commission->save_data();
                }
            }
        }

        /**
         * Register the commission as refunded when there was a refund in the order
         *
         * @param $order_id
         *
         * @since 1.0
         */
        public function register_commissions_refunded( $order_id ) {

            // Ensure the order have commissions processed
            $processed = get_post_meta( $order_id, '_commissions_processed', true );
            $refunded  = get_post_meta( $order_id, '_commissions_refunded', true );

            if ( $processed && $processed == 'yes' && ( empty( $refunded ) || $refunded != 'no' ) ) {
                $order = wc_get_order( $order_id );

                foreach ( $order->get_items() as $item_id => $item ) {
                    if ( empty( $item['commission_id'] ) ) {
                        continue;
                    }

                    // retrieve commission
                    $commission = YITH_Commission( intval( $item['commission_id'] ) );

                    // set commission as refunded
                    $commission->update_status( 'refunded' );
	                $commission->save_data();

                    // Mark commissions as processed
                    update_post_meta( $order_id, '_commissions_refunded', 'yes' );
                }
            }
        }

        /**
         * Register the commission as unpaid when the order is completed
         *
         * @param $order_id
         *
         * @since 1.0
         */
        public function register_commissions_cancelled( $order_id ) {

            // Ensure the order have commissions processed
            $processed = get_post_meta( $order_id, '_commissions_processed', true );
            $cancelled = get_post_meta( $order_id, '_commissions_cancelled', true );

            if ( $processed && $processed == 'yes' && ( empty( $cancelled ) || $cancelled != 'no' ) ) {
                $order = wc_get_order( $order_id );

                foreach ( $order->get_items() as $item_id => $item ) {
                    if ( empty( $item['commission_id'] ) ) {
                        continue;
                    }

                    // retrieve commission
                    $commission = YITH_Commission( intval( $item['commission_id'] ) );

                    // set commission as refunded
                    $commission->update_status( 'cancelled' );
	                $commission->save_data();

                    // Mark commissions as processed
                    update_post_meta( $order_id, '_commissions_cancelled', 'yes' );
                }
            }
        }

        /**
         * Register the commission as pending when the order is on-hold
         *
         * @param $order_id
         *
         * @since 1.0
         */
        public function register_commissions_pending( $order_id ) {

            // Ensure the order have commissions processed
            $processed = get_post_meta( $order_id, '_commissions_processed', true );

            if ( $processed && $processed == 'yes' ) {
                $order = wc_get_order( $order_id );

                foreach ( $order->get_items() as $item_id => $item ) {
                    if ( empty( $item['commission_id'] ) ) {
                        continue;
                    }

                    // retrieve commission
                    $commission = YITH_Commission( intval( $item['commission_id'] ) );

                    // set commission as refunded
                    $commission->update_status( 'pending' );
	                $commission->save_data();
                }
            }
        }

	    /**
	     * Recalculate all refunds of the order of this refund
	     *
	     * @param $new_refund_id
	     *
	     * @since 1.0
	     */
	    public function register_commission_refund( $new_refund_id ) {
		    $refund = new WC_Order_Refund( $new_refund_id );
		    $order = wc_get_order( $refund->post->post_parent );
		    $refunds = array();
		    $global_refunds = array();  // save the refund objects of global refunds
		    $total_refunded = array();

		    // reset commissions calculating (must be before next foreach)
		    foreach ( $order->get_refunds() as $_refund ) {
			    $this->remove_refund_commission_helper( $_refund->id );
			    $this->remove_refund_commission( $_refund->id, false );
		    }

		    // single refunds
		    foreach ( $order->get_refunds() as $_refund ) {

			    // count the line refunds total, to detect if there is some global refund
			    $line_items_refund = 0;

			    /** @var WC_Order_Refund $_refund */
			    foreach ( $_refund->get_items() as $item_id => $item ) {
				    $original_item_id = $item['refunded_item_id'];
				    if ( $commission_id = $order->get_item_meta( $original_item_id, '_commission_id', true ) ) {
					    $refund_amount = $item['line_total'];

					    if ( $refund_amount != 0 ) {
						    $commission = YITH_Commission( $commission_id );

						    if ( ! isset( $total_refunded[ $commission_id ] ) ) {
							    $total_refunded[ $commission_id ] = $refund_amount;
						    } else {
							    $total_refunded[ $commission_id ] += $refund_amount;
						    }

						    $line_items_refund += $refund_amount;

						    $amount = (float) $refund_amount * $commission->rate;

						    // register the amount
						    $refunds[ $_refund->id ][ $commission_id ] = $amount;
					    }
				    }
			    }

			    // detect if there is some global refund applied in this refund
			    if ( $_refund->get_refund_amount() - abs( $line_items_refund ) > 0 ) {
				    $_refund->refund_amount = $_refund->get_refund_amount() - abs( $line_items_refund );
				    $global_refunds[] = $_refund;
			    }

		    }

		    // manage the global refunds
		    foreach ( $global_refunds as $_refund ) {
			    $rate_to_refund = $_refund->get_refund_amount() / ( $order->get_total() - abs( array_sum( $total_refunded ) ) );

			    foreach ( $order->get_items() as $item_id => $item ) {
				    $commission_id = $order->get_item_meta( $item_id, '_commission_id', true );
				    if ( $commission_id ) {
					    $commission = YITH_Commission( $commission_id );

						$to_refund = ( $order->get_line_total( $item, false, false ) - $order->get_total_refunded_for_item( $item_id ) ) * $rate_to_refund;
					    $amount = (float) abs( $to_refund * $commission->get_rate() ) * -1;

					    // register the amount
					    if ( ! isset( $refunds[ $_refund->id ][ $commission_id ] ) ) {
						    $refunds[ $_refund->id ][ $commission_id ] = $amount;
					    } else {
						    $refunds[ $_refund->id ][ $commission_id ] += $amount;
					    }
				    }
			    }
		    }

		    // update the refunded commissions in the order to easy manage these in future
		    foreach ( $refunds as $refund_id => $commissions_refunded ) {
			    foreach ( $commissions_refunded as $commission_id => $amount ) {
				    $commission = YITH_Commission( $commission_id );
				    $note = $refund_id == $new_refund_id ? sprintf( __( 'Refunded %s from order', 'yith_wc_product_vendors' ), wc_price( abs( $amount ) ) ) : '';
				    $commission->update_amount( $amount, $note );
			    }
			    update_post_meta( $refund_id, '_refunded_commissions', $commissions_refunded );
		    }

	    }

	    /**
	     * Retrieve post meta 'refunded_commissions', before the refund will be deleted
	     *
	     * @param $refund_id
	     */
	    public function remove_refund_commission_helper( $refund_id ) {
		    $this->_refunded_commissions = get_post_meta( $refund_id, '_refunded_commissions', true );
	    }

	    /**
	     * Restore a refund when it's deleted from order
	     *
	     * @param $refund_id
	     * @param bool $note
	     *
	     * @since 1.0
	     */
	    public function remove_refund_commission( $refund_id, $note = true ) {
		    if ( isset( $this->_refunded_commissions ) && $refunds = $this->_refunded_commissions ) {

			    // change definitely commissions amount
			    foreach ( $refunds as $commission_id => $amount ) {
				    $commission = YITH_Commission( $commission_id );

				    // update commission
				    $commission->update_amount( abs( $amount ), $note ? sprintf( __( 'Cancelled %s refund from order', 'yith_wc_product_vendors' ), wc_price( abs( $amount ) ) ) : '' );
			    }

			    // remove post meta to delete every track of refunds
			    delete_post_meta( $refund_id, '_refunded_commissions' );

		    }
	    }

        /**
         * The current credit of user
         *
         * @param $user_id
         *
         * @return float
         * @since 1.0
         */
        public function get_user_credit( $user_id ) {
            return floatval( get_user_meta( $user_id, '_vendor_commission_credit', true ) );
        }

        /**
         * Increment the credit to the user
         *
         * @param $user_id
         * @param $amount
         *
         * @since 1.0
         */
        public function update_credit_to_user( $user_id, $amount ) {
            $current = $this->get_user_credit( $user_id );
            $current += $amount;

            update_user_meta( $user_id, '_vendor_commission_credit', $current );
        }

        /**
         * @param $screen_ids array The WC Screen ids
         *
         * @author Andrea Grillo <andrea.grillo@yithemes.com>
         * @since  1.0
         * @return array The screen ids
         * @use woocommerce_screen_ids hooks
         */
        public function add_screen_ids( $screen_ids ) {
            $screen_ids[] = 'toplevel_page_' . $this->_screen;
            return $screen_ids;
        }

        /**
         * Update the commission status by Commissions page
         *
         * @since  1.0
         * @author Andrea Grillo <andrea.grillo@yithemes.com>
         * @return void
         */
        public function table_update_status() {
            $args = array( 'page' => $this->_screen, 'message' => 'error' );

	        $commission_id = ! empty( $_GET['commission_id'] ) ? $_GET['commission_id'] : 0;

	        if ( isset( $_GET['view'] ) ) {
		        $args['view'] = $_GET['view'];
		        $commission_id = $_GET['view'];
	        }

            if ( ! empty( $commission_id ) && ! empty( $_GET['new_status'] ) ) {
                if ( YITH_Commission( $commission_id )->update_status( $_GET['new_status'] ) ) {
                    $args['message'] = 'updated';
                }
            }

            $url = esc_url( add_query_arg( $args, admin_url( 'admin.php' ) ) );
            wp_redirect( $url );
            exit;
        }

        /**
         * Add Screen option
         *
         * @return void
         */
        public function add_screen_option() {
            if ( 'toplevel_page_' . $this->_screen == get_current_screen()->id ) {
                add_screen_option( 'per_page', array( 'label' => __( 'Commissions', 'yith_wc_product_vendors' ), 'default' => 20, 'option' => 'edit_commissions_per_page' ) );

            }
        }

        /**
         * Save custom screen options
         *
         * @param $set      Filter value
         * @param $option   Option id
         * @param $value    The option value
         *
         * @return mixed
         */
        public function set_screen_option( $set, $option, $value ){
            return 'edit_commissions_per_page' == $option ? $value : $set;
        }

        /**
         * Change commission label value
         *
         * @param $attribute_label  The Label Value
         * @param $meta_key         The Meta Key value
         * @param $product          The Product object
         *
         * @return string           The label value
         */
        public function commissions_attribute_label( $attribute_label, $meta_key, $product = false ){
            global $pagenow;

            if( $product && 'post.php' == $pagenow && isset( $_GET['post'] ) && $order = wc_get_order( $_GET['post'] ) ){
                $line_items = $order->get_items( 'line_item' );
                foreach( $line_items as $line_item_id => $line_item ){
                    if( $line_item['product_id'] == $product->id ){
                        $commission_id = wc_get_order_item_meta( $line_item_id, '_commission_id', true );
                        $admin_url = YITH_Commission( $commission_id )->get_view_url( 'admin' );
                        $attribute_label = '_commission_id' == $meta_key ? sprintf( "<a href='%s' class='%s'>" . __( 'commission_id', 'yith_wc_product_vendors' ) . '</a>', $admin_url, 'commission-id-label' ) : $attribute_label;
                    }
                }
            }
            return $attribute_label;
        }

        /**
         * Multiple Delete Bulk commission
         *
         * @param $order_id array  The order ids to apply the bulk action
         * @param $action   string Bulk action type
         *
         * @author Andrea Grillo <andrea.grillo@yithemes.com>
         * @since 1.8.4
         * @return void
         */
        public function bulk_action( $order_ids, $action = 'delete' ){
            switch( $action ){
                case 'delete':
                    foreach ( $order_ids as $order_id ) {
                        $commission_ids = YITH_Commissions()->get_commissions( array( 'order_id' => $order_id, 'status' => $this->get_status() ) );
                        foreach ( $commission_ids as $commission_id ) {
                            $commission = YITH_Commission( $commission_id );
                            if ( $commission_id ) {
                                $commission->remove();
                            }
                        }
                    }
                    break;
            }
        }

        /**
         * Register massive payment
         */
        public function register_massive_payment( $vendor_id, $user_id, $amount, $commission_ids, $status = 'processing' ){
            global $wpdb;
            $last_inserted_id = 0;
            $data = array(
                'vendor_id'        => $vendor_id,
                'user_id'          => $user_id,
                'amount'           => $amount,
                'status'           => $status,
                'payment_date'     => current_time( 'mysql' ),
                'payment_date_gmt' => current_time( 'mysql', 1 ),
            );
            $success = $wpdb->insert( $wpdb->payments, $data );

            if( $success ){
                $last_inserted_id = $wpdb->insert_id;
                foreach( $commission_ids as $commission_id ){
                    $success = $wpdb->insert( $wpdb->payments_relationship, array( 'payment_id' => $last_inserted_id, 'commission_id' => $commission_id ) );
                }
            }

            return $last_inserted_id;
        }
    }
}

/**
 * Main instance of plugin
 *
 * @return YITH_Commissions
 * @since  1.0
 * @author Andrea Grillo <andrea.grillo@yithemes.com>
 */
if ( ! function_exists( 'YITH_Commissions' ) ) {
    function YITH_Commissions() {
        return YITH_Commissions::instance();
    }
}

YITH_Commissions();