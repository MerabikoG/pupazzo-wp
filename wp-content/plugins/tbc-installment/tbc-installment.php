<?php

/*
 * Plugin Name: WooCommerce TBC Installments
 * Plugin URI: https://symbiosis.ge
 * Description: WooCommerce TBC Installments
 * Author: Merab Gvantseladze
 * Author URI: https://symbiosis.ge
 * Version: 1.0.0
 */


add_action('plugins_loaded', function() {
  require_once "vendor/autoload.php";
});


add_filter('woocommerce_payment_gateways', 'tbc_installments_add_gateway_class');
function tbc_installments_add_gateway_class($gateways)
{
    $gateways[] = 'Symbiosis\TbcInstallment\TBC_Installments';
    return $gateways;
}