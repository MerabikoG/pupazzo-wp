<?php
/**
 * Plugin Name: WooCommerce UFC Apple And Google Pay (Free)
 * Plugin URI:  https://symbiosis.ge
 * Description: WooCommerce UFC Apple And Google Pay (Free)
 * Version:     1.0.0
 * Author:      Symbiosis.
 * Author URI:  https://symbiosis.ge/
 * License:     GPL2
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Domain Path: /languages
 * Text Domain: apple-and-google-pay

 *
 * @package     WooCommerce UFC Apple And Google Pay (Free)
 * @author      Symbiosis. https://symbiosis.ge/
 * @copyright   Copyright (c) Symbiosis. (support@symbiosis.ge)
 * @since       1.0.0
 * @license     http://www.gnu.org/licenses/gpl-2.0.html GNU General Public License v2.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Init plugin.
 */

require_once 'class-payment-requests.php';

add_filter( 'woocommerce_payment_gateways', 'symbiosis_add_payment_methods' );
function symbiosis_add_payment_methods( $gateways ) {
	$gateways[] = 'WC_Google_Pay_Gateway';
	$gateways[] = 'WC_Apple_Pay_Gateway';
	return $gateways;
}

add_action( 'plugins_loaded', 'init_payment_classes' );
function init_payment_classes() {
	require_once 'class-payment-google.php';
	require_once 'class-payment-apple.php';
}