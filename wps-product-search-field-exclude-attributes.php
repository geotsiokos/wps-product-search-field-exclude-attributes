<?php
/**
 * Plugin Name: WPS Product Search Field Exclude Attributes
 * Plugin URI: https://github.com/geotsiokos/wps-product-search-field-exclude-attributes
 * Description: Exclude products from search by attribute(s) when using the Product Search Field by <a href="https://woo.com/products/woocommerce-product-search/">WooCommerce Product Search</a> 
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
		add_action('woocommerce_product_search_service_post_ids_for_request', array( __CLASS__, 'woocommerce_product_search_service_post_ids_for_request' ), 10, 2 );
	}

	public static function woocommerce_product_search_service_post_ids_for_request( &$products, $context ) {
		$excluded_attributes = array( 'brand', 'size' );
		foreach ( $products as $key => $product_id ) {
			$product = wc_get_product( $product_id );
			if ( $product ) {
				$attributes = $product->get_attributes();
				$attribute_terms = array_keys( $attributes );
				foreach( $excluded_attributes as $term ) {
					$pa_term = 'pa_' . $term;
					if ( in_array( $pa_term, $attribute_terms ) ) {
						unset( $products[$key] );
					}
				}
			}
		}
	}
} WPS_Product_Search_Field_Exclude_Attributes::init();