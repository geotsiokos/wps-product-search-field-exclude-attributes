<?php
/**
 * Plugin Name: WPS Product Search Field Exclude Attributes
 * Plugin URI: @todo link to repo
 * Description: Exclude product attributes when using the Product Search Field by <a href="https://woo.com/products/woocommerce-product-search/">WooCommerce Product Search</a> 
 * Version: 1.0.0
 * Author: gtsiokos
 * Author URI: http://www.netpad.gr
 * Donate-Link: http://www.netpad.gr
 * License: GPLv3
 */

if ( !defined( 'ABSPATH' ) ) {
	exit;
}
class WPS_Product_Search_Field_Exclude_Attributes {

	public static function init() {
		//add_action( 'wp_ajax_product_search', array( __CLASS__, 'wp_ajax_product_search' ), 9 );
		//add_action( 'wp_ajax_nopriv_product_search', array( __CLASS__, 'wp_ajax_product_search' ), 9 );
		add_action('woocommerce_product_search_service_post_ids_for_request', array( __CLASS__, 'woocommerce_product_search_service_post_ids_for_request' ), 10, 2 );
	}

	public static function wp_ajax_product_search() {
		//add_action('woocommerce_product_search_service_post_ids_for_request', array( __CLASS__, 'woocommerce_product_search_service_post_ids_for_request' ), 10, 2 );
	}

	public static function woocommerce_product_search_service_post_ids_for_request( &$products, $context ) {
		$excluded_attributes = apply_filters( 'wps-product-search-field-exclude-attributes', array( 'pa_brand' ) );
		foreach ( $products as $key => $product_id ) {
			$product = wc_get_product( $product_id );
			if ( $product ) {
				$attributes = $product->get_attributes();
				$attribute_terms = array_keys( $attributes );
				foreach( $attribute_terms as $term ) {
					if ( in_array( $term, $excluded_attributes ) ) {
						unset( $products[$key] );
					}
				}
			}
		}
	}
} WPS_Product_Search_Field_Exclude_Attributes::init();