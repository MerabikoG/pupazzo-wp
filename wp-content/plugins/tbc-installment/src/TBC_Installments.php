<?php

namespace Symbiosis\TbcInstallment;

use Symbiosis\TbcInstallment\Traits\Options;
use WC_Payment_Gateway;

class TBC_Installments extends WC_Payment_Gateway
{

	private $request;

	use Options;
	function __construct()
	{
		$this->id = 'tbc_installments';
		$this->icon = '';
		$this->has_fields = true;
		$this->order_button_text = 'TBC განვადება';
		$this->method_title = 'TBC განვადება';
		$this->method_description = 'Description of TBC Installments';

		$this->supports = array(
			'products'
		);

		$this->init_form_fields();

		$this->init_settings();
		$this->title = $this->get_option('title');
		$this->description = $this->get_option('description');
		$this->enabled = $this->get_option('enabled');

		$this->api_secret = $this->get_option('api_secret');
		$this->api_key = $this->get_option('api_key');
		$this->merchant = $this->get_option('merchant');
		$this->campaign = $this->get_option('campaign');
		$this->url = $this->get_option('url');

		add_action('woocommerce_update_options_payment_gateways_' . $this->id, array($this, 'process_admin_options'));
	}

	public function process_payment($order_id)
	{
		$order = wc_get_order($order_id);
		$request = new TBC_Request($this->url, $this->api_secret, $this->api_key, $this->campaign, $this->merchant);
		$order = wc_get_order($order_id);

		$data = [
			"merchantKey" => $this->merchant,
			"priceTotal" => floatval($order->get_total()),
			"campaignId" => $this->campaign,
			"invoiceId" => 'wc_' . $order_id,
			"products" => []
		];

		if ($order->get_shipping_total()) {
			$data['products'][] = [
				'name' => "მიწოდების საფასური",
				'quantity' => 1,
				'price' => $order->get_shipping_total(),
			];
		}

		foreach ($order->get_items() as $product) {
			$data['products'][] = [
				"name" => str_replace(['\'', '"'], "", $product->get_name()),
				"price" => floatval($product->get_total() / $product->get_quantity()),
				"quantity" => $product->get_quantity(),
			];
		}

		$transaction = $request->createOrder($data);
		update_post_meta($order->get_id(), '_transaction_id', $transaction['id']);
		if ($transaction['success']) {
			WC()->cart->empty_cart();
			return [
				'result' => 'success',
				'redirect' => $transaction['redirect']
			];
		} else {
			return [
				'result' => 'failure',
				'message' => __('something went wrong')
			];
		}
	}

	public function log($step, $message, $order)
	{
		if (is_array($message) || is_object($message)) {
			$message = json_encode($message);
		}

		wc_get_logger()->debug($step . ': ' . $message, array('source' => 'tbc_installment_' . $order));
	}
}
