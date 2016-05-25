<?php

defined('ABSPATH') or die();

/**
 * Class to make WJECF compatible with WPML
 */
class WJECF_WPML extends Abstract_WJECF_Plugin {

	public function __construct() {
		add_action('init', array( $this, 'controller_init' ) );
	}

	public function controller_init() {
		global $sitepress;
		if ( isset( $sitepress ) ) {
			//WJECF_Controller hooks
			add_filter( 'wjecf_get_cart_product_ids', array( $this, 'filter_get_cart_product_ids' ), 10, 2 );
			add_filter( 'wjecf_get_cart_product_cat_ids', array( $this, 'filter_get_cart_product_cat_ids' ), 10, 2 );
		}
	}

//HOOKS

	public function filter_get_cart_product_ids( $product_ids, $cart ) {
		return $this->get_translation_product_ids( $product_ids );
	}

	public function filter_get_cart_product_cat_ids( $product_cat_ids, $cart ) {
		return $this->get_translation_product_cat_ids( $product_cat_ids );
	}


//FUNCTIONS

	/**
	 * If WPML exists, get the ids of all the product translations. Otherwise return the original array
	 * 
	 * @param int|array $product_ids The product_ids to find the translations for
	 * @return array The product ids of all translations
	 * 
	 */
	public function get_translation_product_ids( $product_ids ) {
		//Make sure it's an array
		if ( ! is_array( $product_ids ) ) {
			$product_ids = array( $product_ids );
		}

		//WPML exists?
		global $sitepress;
        if ( ! isset( $sitepress ) ) {
        	return $product_ids;
        }

        $translation_product_ids = array();
        foreach( $product_ids as $prod_id) {
            $post_type = get_post_field( 'post_type', $prod_id );
            $trid = $sitepress->get_element_trid( $prod_id, 'post_' . $post_type );
            $translations = $sitepress->get_element_translations( $trid, 'post_' . $post_type );
            foreach( $translations as $translation ){
                $translation_product_ids[] = $translation->element_id;
            }
        }
        return $translation_product_ids;
	}

	/**
	 * If WPML and WPML WooCommerce exists, get the ids of all the product_cat translations. Otherwise return the original array
	 * 
	 * @param int|array $product_cat_ids The product_cat_ids to find the translations for
	 * @return array The product_cat ids of all translations
	 * 
	 */
	public function get_translation_product_cat_ids( $product_cat_ids ) {
		//Make sure it's an array
		if ( ! is_array( $product_cat_ids ) ) {
			$product_cat_ids = array( $product_cat_ids );
		}

		//WPML and WPML WooCommerce exist?
		global $sitepress, $woocommerce_wpml;
        if ( ! isset( $sitepress ) || ! isset( $woocommerce_wpml ) ) {
        	return $product_cat_ids;
        }

        $translation_product_cat_ids = array();
        foreach( $product_cat_ids as $cat_id) {
            $term = $woocommerce_wpml->products->wcml_get_term_by_id( $cat_id, 'product_cat' );
            $trid = $sitepress->get_element_trid( $term->term_taxonomy_id, 'tax_product_cat' );
            $translations = $sitepress->get_element_translations( $trid, 'tax_product_cat' );

            foreach( $translations as $translation ){
                $translation_product_cat_ids[] = $translation->term_id;
            }
        }
        return $translation_product_cat_ids;
	}

}
