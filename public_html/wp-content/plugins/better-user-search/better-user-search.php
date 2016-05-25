<?php
/**
 * Plugin Name: Better User Search
 * Plugin URI: https://wordpress.org/plugins/better-user-search/
 * Description: Improves the search for users in the backend significantly: Search for first name, last, email and much more of users instead of only nicename.
 * Version: 1.1.1
 * Author: Dale Higgs
 * Author URI: mailto:dale3h@gmail.com
 * Requires at least: 3.1
 * Tested up to: 4.4.2
 */

/**
 * This plugin is based on David Stöckl's Improved User Search in Backend plugin.
 * Although it has been completely rewritten, this notice is here to provide
 * credit to the original and inspiring author.
 *
 * Original Author: David Stöckl - http://www.blackbam.at/
 */

/**
 * @todo Add support for quoting keywords, example: "Fort Worth"
 * @todo Detect other plugins and automatically add suggested meta keys by default
 * @todo Detect Advanced Custom Fields and hide secondary (underscored) meta keys
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Run the init function when it's time to load the plugin
add_action( 'plugins_loaded', array( 'Better_User_Search', 'init' ) );

// This is here to prevent redeclaration of the class
if ( ! class_exists( 'Better_User_Search' ) ) {
	// This is where the magic happens!
	class Better_User_Search {
		// Plugin version
		public static $version = '1.1.1';

		// Instance of the class
		protected static $instance;

		// This function is called when loading our plugin
		public static function init() {
			// Check to see if an instance already exists
			if ( is_null( self::$instance ) ) {
				// Create a new instance
				self::$instance = new self;
			}

			// Return the instance
			return self::$instance;
		}

		// Class constructor
		public function __construct() {
			// This plugin is for the backend only
			if ( ! is_admin() ) {
				return;
			}

			// Add the overwrite actions for the search
			add_action( 'pre_user_query', array( $this, 'pre_user_query' ), 100 );

			// Add the backend menu page
			add_action( 'admin_menu', array( $this, 'admin_menu' ) );

			// Add a link to the Settings page on the Plugins page
			add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), array( $this, 'plugin_action_links' ) );
		}

		// Add the options page
		public function admin_menu() {
			// Add the options page
			$page = add_options_page(
				__( 'Better User Search Settings', 'better-user-search' ),
				__( 'User Search', 'better-user-search' ),
				'manage_options',
				'bu-search',
				array( $this, 'options_page' )
			);

			// Hooks for our scripts and stylesheets
			add_action( 'admin_print_styles-' . $page, array( $this, 'admin_styles' ) );
			add_action( 'admin_print_scripts-' . $page, array( $this, 'admin_scripts' ) );

			// This is so we can register our scripts and stylesheets
			add_action( 'admin_init', array( $this, 'admin_init' ) );
		}

		// Plugin initialization
		public function admin_init() {
			// Version so that the browser doesn't cache when we release new versions
			$version = self::$version;

			// Register stylesheets and scripts
			wp_register_style( 'bu-search-chosen', plugins_url( 'css/chosen.min.css', __FILE__ ), array(), $version );
			wp_register_script( 'bu-search-chosen', plugins_url( 'js/chosen.jquery.min.js', __FILE__ ), array( 'jquery' ), $version );
			wp_register_script( 'bu-search', plugins_url( 'js/bu-search.js', __FILE__ ), array( 'jquery' ), $version, true );

			// Register our setting so that it's automatically managed
			register_setting( 'bu-search-settings', 'bu_search_meta_keys' );
		}

		// Add our stylesheets
		public function admin_styles() {
			wp_enqueue_style( 'bu-search-chosen' );
		}

		// Add our scripts
		public function admin_scripts() {
			wp_enqueue_script( 'bu-search-chosen' );
			wp_enqueue_script( 'bu-search' );
		}

		// Add Settings link on Plugins page
		public function plugin_action_links( $actions ) {
			// Define our custom action link
			$custom_actions = array(
				sprintf( '<a href="%s">%s</a>', admin_url( 'options-general.php?page=bu-search' ), __( 'Settings' ) ),
			);

			// Merge our custom actions with the existing actions
			return array_merge( $custom_actions, $actions );
		}

		// Add the options page
		public function options_page() {
			// Get the user-defined meta keys
			$meta_keys = $this->get_meta_keys();

			// Get all of the meta keys (for our list)
			$all_meta_keys = $this->get_all_meta_keys();

			// Output the form
			?>
			<div class="wrap">
				<h2><?php _e( 'Better User Search Settings', 'better-user-search' ); ?></h2>

				<form method="post" action="options.php">
					<?php settings_fields( 'bu-search-settings' ); ?>
					<?php do_settings_sections( 'bu-search' ); ?>

					<table class="form-table">
						<tr valign="top">
							<th scope="row"><?php _e( 'Searchable Meta Fields', 'better-user-search' ); ?></th>
							<td>
								<select data-placeholder="<?php esc_attr_e( 'Choose some meta fields...', 'better-user-search' ); ?>" name="bu_search_meta_keys[]" multiple class="chosen-select">
									<?php foreach ( $all_meta_keys as $meta_key ): ?><option<?php selected( in_array( $meta_key, $meta_keys ), true ); ?>><?php echo esc_html( $meta_key ); ?></option><?php endforeach ?>
								</select>
								<p><a class="chosen-select-all button" href="#"><?php _e( 'Select all', 'better-user-search' ); ?></a> <a class="chosen-select-none button" href="#"><?php _e( 'Select none', 'better-user-search' ); ?></a></p>
								<p class="description"><?php printf( __( 'Use this list to configure which meta fields are searchable on the <a href="%s">Users</a> page.', 'better-user-search' ), admin_url( 'users.php' ) ); ?></p>
							</td>
						</tr>
					</table>

					<?php submit_button(); ?>
				</form>
			</div>
			<?php
		}

		// The actual improvement of the query
		public function pre_user_query( $user_query ) {
			// Must not be searching for email
			//   Commented out because it seems somewhat unnessary
			//   If performance complaints are received, consider making this a setting
			/*
			if ( strpos( $user_query->query_where, '@' ) !== false ) {
				return false;
			}
			*/

			// Variable to determine if we are going to intercept or not
			$intercept_query = false;

			// Users page integration
			if ( isset( $_GET['s'] ) ) {
				$term = sanitize_text_field( $_GET['s'] );

				if ( stripos( $_SERVER['REQUEST_URI'], 'users.php' ) !== false && ! empty( $term ) ) {
					$intercept_query = true;
				}
			}

			// WooCommerce Orders customer search integration
			if ( ! $intercept_query && $this->plugin_active( 'wc' ) && isset( $_GET['action'] ) && isset( $_GET['term'] ) ) {
				$action = $_GET['action'];
				$term   = sanitize_text_field( $_GET['term'] );

				if ( 'woocommerce_json_search_customers' === $action && ! empty( $term ) ) {
					$intercept_query = true;
				}
			}

			// Bail out if we are not intercepting the query
			if ( ! $intercept_query ) {
				return false;
			}

			// Global DB object
			global $wpdb;

			// Get the data we need from helper methods
			$terms     = $this->get_search_terms();
			$meta_keys = $this->get_meta_keys();

			// Are we performing an AND (default) or an OR?
			$search_with_or = in_array( 'or', $terms );

			if ( $search_with_or ) {
				// Remove the OR keyword(s) from the terms
				$terms = array_diff( $terms, array( 'or', 'and' ) );

				// Reset the array keys
				$terms = array_values( $terms );
			}

			// We use a permanent table because you cannot reference MySQL temporary tables more than once per query
			$mktable = "{$wpdb->prefix}better_user_search_meta_keys";

			// Create our table to store the meta keys
			$wpdb->query( $sql = "CREATE TABLE IF NOT EXISTS {$mktable} (meta_key VARCHAR(255) NOT NULL);" );

			// Empty the table to ensure that we have an accurate set of meta keys
			$wpdb->query( $sql = "TRUNCATE TABLE {$mktable};" );

			// Insert the meta keys into our table
			$prepare_values_array = array_fill( 0, count( $meta_keys ), '(%s)' );
			$prepare_values = implode( ", ", $prepare_values_array ); // Add "\n\t\t\t\t\t\t" after the comma for easier debugging

			$insert_sql = $wpdb->prepare( "
				INSERT INTO {$mktable}
					(meta_key)
				VALUES
					{$prepare_values};
			", $meta_keys );

			$wpdb->query( $insert_sql );

			// Build our data for $wpdb->prepare
			$values = array();

			// Make sure we replicate each term XX number of times (refer to query below for correct number)
			foreach ( $terms as $term ) {
				for ( $i = 0; $i < 6; $i++ ) {
					$values[] = "%{$term}%";
				}
			}

			// Our last value is for HAVING COUNT(*), so let's add that
			// Note the min count is 1 if we found OR in the terms
			$values[] = ( $search_with_or !== false ? 1 : count( $terms ) );

			// Query for matching users
			$user_ids = $wpdb->get_col( $sql = $wpdb->prepare( "
				SELECT user_id
				FROM (" . implode( 'UNION ALL', array_fill( 0, count( $terms ), "
					SELECT DISTINCT u.ID AS user_id
					FROM {$wpdb->users} u
					INNER JOIN {$wpdb->usermeta} um
					ON um.user_id = u.ID
					INNER JOIN {$mktable} mk
					ON mk.meta_key = um.meta_key
					WHERE LOWER(um.meta_value) LIKE %s
					OR LOWER(u.user_login) LIKE %s
					OR LOWER(u.user_nicename) LIKE %s
					OR LOWER(u.user_email) LIKE %s
					OR LOWER(u.user_url) LIKE %s
					OR LOWER(u.display_name) LIKE %s
				" ) ) . ") AS user_search_union
				GROUP BY user_id
				HAVING COUNT(*) >= %d;
			", $values ) );

			// Change query to include our new user IDs
			if ( is_array( $user_ids ) && count( $user_ids ) ) {
				// Combine the IDs into a comma separated list
				$id_string = implode( ',', $user_ids );

				// Build the SQL we are adding to the query
				$extra_sql = " OR ID IN ({$id_string})";

				// @dale3h 2016/01/28 21:51:00 - Admin Columns Pro fix
				$add_after    = 'WHERE ';
				$add_position = strpos( $user_query->query_where, $add_after ) + strlen( $add_after );

				// Add the query to the end, after wrapping the rest in parenthesis
				$user_query->query_where = substr( $user_query->query_where, 0, $add_position ) . '(' . substr( $user_query->query_where, $add_position ) . ')' . $extra_sql;
			}
		}

		// Get array of user search terms
		public function get_search_terms() {
			// Get the WordPress search term(s)
			$terms = trim( strtolower( stripslashes( $_GET['s'] ) ) );

			// Get the WooCommerce search term(s)
			if ( empty( $terms ) && $this->plugin_active( 'wc' ) ) {
				$terms = trim( strtolower( stripslashes( $_GET['term'] ) ) );
			}

			// Bail out if we cannot find any search term(s)
			if ( empty( $terms ) ) {
				return array();
			}

			// Split terms by space into an array
			$terms = explode( ' ', $terms );

			// Remove empty terms
			foreach ( $terms as $key => $term ) {
				if ( empty( $term ) ) {
					unset( $terms[ $key ] );
				}
			}

			// Reset the array keys
			$terms = array_values( $terms );

			// Return the array of terms
			return $terms;
		}

		// Generate an array of default meta keys based on active plugins that are compatible
		public function get_default_meta_keys() {
			// WordPress defaults
			$meta_keys = array(
				'first_name',
				'last_name',
			);

			// WooCommerce defaults
			if ( $this->plugin_active( 'wc' ) ) {
				$meta_keys = array_merge( $meta_keys, array(
					'billing_address_1',
					'billing_address_2',
					'billing_city',
					'billing_company',
					'billing_country',
					'billing_email',
					'billing_first_name',
					'billing_last_name',
					'billing_phone',
					'billing_postcode',
					'billing_state',
					'shipping_address_1',
					'shipping_address_2',
					'shipping_city',
					'shipping_company',
					'shipping_country',
					'shipping_first_name',
					'shipping_last_name',
					'shipping_postcode',
					'shipping_state',
				) );
			}

			// Return the default meta keys
			return $meta_keys;
		}

		// Get user-defined meta keys
		public function get_meta_keys() {
			// Get the meta keys from the settings
			$meta_keys = get_option( 'bu_search_meta_keys', $this->get_default_meta_keys() );

			// Make it an array if it isn't one already
			if ( ! is_array( $meta_keys ) ) {
				$meta_keys = ! empty( $meta_keys ) ? array( $meta_keys ) : array();
			}

			// Return the meta keys
			return $meta_keys;
		}

		// Get all searchable meta keys from the wp_usermeta table
		public function get_all_meta_keys() {
			// Global DB object
			global $wpdb;

			// Query for all meta keys from the user meta table
			return $wpdb->get_col( $sql = "
				SELECT DISTINCT meta_key
				FROM {$wpdb->usermeta}
				WHERE meta_key IS NOT NULL
				AND meta_key != ''
				ORDER BY meta_key;
			" );
		}

		// Function to detect if a specific plugin is active
		public function plugin_active( $plugin ) {
			// Shorthand definitions for ease-of-use
			$plugins = array(
				'wc' => 'woocommerce/woocommerce.php',
			);

			// If shorthand is used, get the script name from the array
			if ( isset( $plugins[ $plugin ] ) ) {
				$plugin = $plugins[ $plugin ];
			}

			// Return the active status of the plugin
			return in_array( $plugin, apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) );
		}
	}
}