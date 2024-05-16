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
		foreach( $excluded_attributes as $attribute ) {
			$taxonomies[] = array(
				'taxonomy' => 'pa_' . $attribute,
				'field'    => 'slug',
				'terms'    => '',
				'operator' => 'NOT IN'
			);
		}

		$excluded_product_ids = get_posts(
			array(
				'post_type'      => 'product',
				'posts_per_page' => -1,
				'post_status'    => 'publish',
				'tax_query'      => array(
					'relation' => 'OR',
					$taxonomies
				),
				'fields'         => 'ids',
			)
		);

		$products = array_diff( $products, $excluded_product_ids );
	}
} WPS_Product_Search_Field_Exclude_Attributes::init();