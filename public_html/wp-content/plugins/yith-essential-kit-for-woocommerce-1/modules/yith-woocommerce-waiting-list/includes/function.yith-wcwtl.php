<?php
/**
 * General Function
 *
 * @author Yithemes
 * @package YITH WooCommerce Waiting List
 * @version 1.0.0
 */

if ( ! defined( 'YITH_WCWTL' ) ) {
	exit;
} // Exit if accessed directly

if( ! function_exists( 'yith_waitlist_get' ) ) {
	/**
	 * Get waitlist for product id
	 *
	 * @since 1.0.0
	 * @param int $id
	 * @return array
	 * @author Francesco Licandro <francesco.licandro@yithemes.com>
	 */
	function yith_waitlist_get( $id ) {
		$id = intval( $id );
		return get_post_meta( $id, YITH_WCWTL_META, true );
	}
}

if( ! function_exists( 'yith_waitlist_save' ) ) {
	/**
	 * Save waitlist for product id
	 *
	 * @since 1.0.0
	 * @param int $id
	 * @param array $waitlist
	 * @return void
	 * @author Francesco Licandro <francesco.licandro@yithemes.com>
	 */
	function yith_waitlist_save( $id, $waitlist ) {
		$id = intval( $id );
		update_post_meta( $id, YITH_WCWTL_META, $waitlist );
	}
}

if( ! function_exists( 'yith_waitlist_user_is_register' ) ) {
	/**
	 * Check if user is already register for a waitlist
	 *
	 * @since 1.0.0
	 * @param string $user
	 * @param array $waitlist
	 * @return bool
	 * @author Francesco Licandro <francesco.licandro@yithemes.com>
	 */
	function yith_waitlist_user_is_register( $user, $waitlist ) {
		return in_array( $user, $waitlist );
	}
}

if( ! function_exists( 'yith_waitlist_register_user' ) ) {
	/**
	 * Register user to waitlist
	 *
	 * @since 1.0.0
	 * @param string $user User email
	 * @param int $id Product id
	 * @return bool
	 * @author Francesco Licandro <francesco.licandro@yithemes.com>
	 */
	function yith_waitlist_register_user( $user, $id ) {

		$waitlist = yith_waitlist_get( $id );

		if ( ! is_email( $user ) || ( is_array( $waitlist ) && yith_waitlist_user_is_register( $user, $waitlist ) ) )
			return false;

		$waitlist[] = $user;
		// save it
		yith_waitlist_save( $id, $waitlist );

		return true;
	}
}

if( ! function_exists( 'yith_waitlist_unregister_user' ) ) {
	/**
	 * Unregister user from waitlist
	 *
	 * @since 1.0.0
	 * @param string $user User email
	 * @param int $id Product id
	 * @return bool
	 * @author Francesco Licandro <francesco.licandro@yithemes.com>
	 */
	function yith_waitlist_unregister_user( $user, $id ) {

		$waitlist = yith_waitlist_get( $id );

		if( is_array( $waitlist ) && yith_waitlist_user_is_register( $user, $waitlist ) ) {
			$waitlist = array_diff( $waitlist, array ( $user ) );
			// save it
			yith_waitlist_save( $id, $waitlist );
			return true;
		}

		return false;
	}
}

if( ! function_exists( 'yith_waitlist_get_registered_users' ) ) {
	/**
	 * Get registered users for product waitlist
	 *
	 * @since 1.0.0
	 * @param int $id Product id
	 * @return mixed
	 * @author Francesco Licandro <francesco.licandro@yithemes.com>
	 */
	function yith_waitlist_get_registered_users( $id ) {

		$waitlist = yith_waitlist_get( $id );
		$users = array();

		if( is_array( $waitlist ) ) {
			foreach( $waitlist as $key => $email ) {
				$users[] = $email;
			}
		}

		return $users;
	}
}

if( ! function_exists( 'yith_waitlist_empty' ) ) {
	/**
	 * Empty waitlist by product id
	 *
	 * @since 1.0.0
	 * @param int $id Product id
	 * @return void
	 * @author Francesco Licandro <francesco.licandro@yithemes.com>
	 */
	function yith_waitlist_empty( $id ) {
		update_post_meta( $id, YITH_WCWTL_META, array() );
	}
}

