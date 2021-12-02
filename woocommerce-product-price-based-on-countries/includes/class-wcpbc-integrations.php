<?php
/**
 * Integrations
 *
 * Handle integrations between PBC and 3rd-Party plugins
 *
 * @version 1.6.14
 * @package WCPBC
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * WCPBC_Integrations
 */
class WCPBC_Integrations {

	/**
	 * Add 3rd-Party plugins integrations
	 */
	public static function add_third_party_plugin_integrations() {

		$third_party_integrations = array(
			'AngellEYE_Gateway_Paypal'     => dirname( __FILE__ ) . '/integrations/class-wcpbc-paypal-express-angelleye.php',
			'Sitepress'                    => dirname( __FILE__ ) . '/integrations/class-wcpbc-admin-translation-management.php',
			'WC_Gateway_Twocheckout'       => dirname( __FILE__ ) . '/integrations/class-wcpbc-gateway-2checkout.php',
			'WC_Product_Addons'            => dirname( __FILE__ ) . '/integrations/class-wcpbc-product-addons-basic.php',
			'WC_Dynamic_Pricing'           => dirname( __FILE__ ) . '/integrations/class-wcpbc-dynamic-pricing-basic.php',
			'WoocommerceGpfCommon'         => dirname( __FILE__ ) . '/integrations/class-wcpbc-gpf.php',
			'WCS_ATT_Abstract_Module'      => dirname( __FILE__ ) . '/integrations/class-wcpbc-wcs-att.php',
			'WC_Gateway_PPEC_Plugin'       => dirname( __FILE__ ) . '/integrations/class-wcpbc-gateway-paypal-express-checkout.php',
			'RP_WCDPD'                     => dirname( __FILE__ ) . '/integrations/class-wcpbc-rightpress-product-price-shop.php',
			'woocommerce_payu_add_gateway' => dirname( __FILE__ ) . '/integrations/class-wcpbc-payu-payment-gateway.php',
			'\Elementor\Plugin'            => dirname( __FILE__ ) . '/integrations/class-wcpbc-elementor.php',
			'WC_Shipping_UPS_Init'         => dirname( __FILE__ ) . '/integrations/class-wcpbc-shipping-ups-fedex.php',
			'WC_Shipping_Fedex_Init'       => dirname( __FILE__ ) . '/integrations/class-wcpbc-shipping-ups-fedex.php',
			'Aelia\WC\EU_VAT_Assistant\WC_Aelia_EU_VAT_Assistant' => dirname( __FILE__ ) . '/integrations/class-wcpbc-eu-vat-assistant.php',
		);

		foreach ( $third_party_integrations as $class => $integration_file ) {

			if ( class_exists( $class ) || function_exists( $class ) ) {
				include_once $integration_file;
			}
		}

		/**
		 * Woo Discount Rules by Flycart.
		 *
		 * @since 2.0.11
		 * @see https://wordpress.org/plugins/woo-discount-rules/
		 */
		if ( defined( 'WDR_SLUG' ) && 'woo_discount_rules' === WDR_SLUG ) {
			// For AJAX Geolocation increment the filter priority.
			if ( WCPBC_Ajax_Geolocation::is_enabled() ) {
				remove_filter( 'woocommerce_get_price_html', array( 'WCPBC_Ajax_Geolocation', 'price_html_wrapper' ), 0, 2 );
				add_filter( 'woocommerce_get_price_html', array( 'WCPBC_Ajax_Geolocation', 'price_html_wrapper' ), 110, 2 );
			}
		}
	}

}
add_action( 'plugins_loaded', array( 'WCPBC_Integrations', 'add_third_party_plugin_integrations' ) );
