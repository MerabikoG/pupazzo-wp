<?php
class WC_Google_Pay_Gateway extends WC_Payment_Gateway {

  public $testmode;
  public $private_key;
  public $publishable_key;
  public $gateway;
  public $cert_path;
  public $cert_pass;

  public function __construct() {

    $this->id = 'google_pay';
    $this->icon = '';
    $this->has_fields = false;
    $this->method_title = 'Google Pay';
    $this->method_description = 'Description of Google Pay payment gateway';
    $this->order_button_text = __('გადახდა', 'tbc-gateway-free');

    $this->supports = array('products', 'refunds');

    $this->init_form_fields();

    $this->init_settings();
    $this->title = $this->get_option( 'title' );
    $this->description = $this->get_option( 'description' );
    $this->cert_path = $this->get_option('cert_path');
    $this->cert_pass = $this->get_option('cert_pass');

    $this->enabled = $this->get_option( 'enabled' );
    $this->testmode = 'yes' === $this->get_option( 'testmode' );
    $this->private_key = $this->testmode ? $this->get_option( 'test_private_key' ) : $this->get_option( 'private_key' );
    $this->publishable_key = $this->testmode ? $this->get_option( 'test_publishable_key' ) : $this->get_option( 'publishable_key' );

    add_action('woocommerce_api_redirect_to_payment_form_google', array($this, 'redirect_to_payment_form'));
  
    // This action hook saves the settings
    add_action( 'woocommerce_update_options_payment_gateways_' . $this->id, array( $this, 'process_admin_options' ) );
  
    // We need custom JavaScript to obtain a token
    add_action( 'wp_enqueue_scripts', array( $this, 'payment_scripts' ) );
    
    // You can also register a webhook here
    // add_action( 'woocommerce_api_{webhook name}', array( $this, 'webhook' ) );
   }

   public function init_form_fields() {

    $this->form_fields = array(
      'enabled' => array(
        'title'       => 'Enable/Disable',
        'label'       => 'Enable Google Pay Gateway',
        'type'        => 'checkbox',
        'description' => '',
        'default'     => 'no'
      ),
      'title' => array(
        'title'       => 'Title',
        'type'        => 'text',
        'description' => 'This controls the title which the user sees during checkout.',
        'default'     => 'Google Pay',
        'desc_tip'    => true,
      ),
      'description' => array(
        'title'       => 'Description',
        'type'        => 'textarea',
        'description' => 'This controls the description which the user sees during checkout.',
        'default'     => 'Pay with your Google Pay via our super-cool payment gateway.',
      ),
      'merchant_host' => array(
        'title'       => 'Merchant host',
        'type'        => 'select',
        'class'       => 'wc-enhanced-select',
        'description' => '',
        'default'     => 'ecommerce',
        'desc_tip'    => true,
        'options'     => array(
          'securepay' => 'Securepay',
          'ecommerce' => 'Ecommerce',
        ),
      ),
      'cert_path'     => array(
        'title'       => 'Certificate path',
        'type'        => 'text',
        'description' => 'Absolute path to certificate in .pem format.',
        'default'     => '/',
      ),
      'cert_pass'     => array(
        'title' => 'Certificate passphrase',
        'type'  => 'text',
      ),
    );
  }

  public function payment_scripts() {

    // we need JavaScript to process a token only on cart/checkout pages, right?
    if( ! is_cart() && ! is_checkout() && ! isset( $_GET[ 'pay_for_order' ] ) ) {
      return;
    }
  
    // if our payment gateway is disabled, we do not have to enqueue JS too
    if( 'no' === $this->enabled ) {
      return;
    }
  
    // no reason to enqueue JavaScript if API keys are not set
    if( empty( $this->private_key ) || empty( $this->publishable_key ) ) {
      return;
    }
  
    // do not work with card detailes without SSL unless your website is in a test mode
    if( ! $this->testmode && ! is_ssl() ) {
      return;
    }
    // wp_enqueue_script( 'symbiosis_js', 'some payment processor site/api/token.js' );
    // wp_register_script( 'woocommerce_symbiosis', plugins_url( 'symbiosis.js', __FILE__ ), array( 'jquery', 'symbiosis_js' ) );
    // wp_localize_script( 'woocommerce_symbiosis', 'symbiosis_params', array(
    // 	'publishableKey' => $this->publishable_key
    // ) );
  
    // wp_enqueue_script( 'woocommerce_symbiosis' );
  
  }

  public function payment_fields() {
    return '';
  }

  public function process_payment( $order_id ) {
    $order = wc_get_order( $order_id );

    $currency = $order->get_currency() ? $order->get_currency() : get_woocommerce_currency();
    $amount = $order->get_total();
    $this->gateway = new Symbiosis_Payment_Request($this->cert_path, $this->cert_pass, $_SERVER['REMOTE_ADDR']);

    /* translators: %s order id */
    $this->gateway->description = sprintf(__('Order id %s', 'gateway-gateway-free'), $order->get_id());
    $this->gateway->language = "gka";
    $this->gateway->amount = $amount * 100;
    $this->gateway->currency = 981;

    $start = $this->gateway->prepare_fields();

    $trans_id = $start['TRANSACTION_ID'];
    update_post_meta($order_id, '_transaction_id', $trans_id);

    WC()->cart->empty_cart();

    return array(
      'result' => 'success',
      'messages' => __('Success! redirecting to Tbc now ...', 'tbc-gateway-free'),
      'redirect' => $this->get_payment_form_url($trans_id),
    );
  }

  public function get_payment_form_url($trans_id) {
    return sprintf('%s/wc-api/redirect_to_payment_form_google?merchant_host=%s&transaction_id=%s', get_bloginfo('url'), $this->get_option('merchant_host'), rawurlencode($trans_id));
  }

  public function process_refund($order_id, $amount = null, $reason = '')
	{
		// Do your refund here. Refund $amount for the order with ID $order_id
    $this->gateway = new Symbiosis_Payment_Request($this->cert_path, $this->cert_pass, $_SERVER['REMOTE_ADDR']);

//		if ( $order -> get_status() != 'completed') {
		$order = wc_get_order($order_id);
		$order_date_timestamp = $order->get_date_created()->getTimestamp();
		$order_date = date_create(date('Y-m-d', $order_date_timestamp));
		$now = date_create(date('Y-m-d'));
		$diff = date_diff($order_date, $now);
		$amount_to_tetri = $amount * 100;
		$trans_id = get_post_meta($order_id, '_transaction_id', true);

		//		if ( $order -> get_status() != 'completed') {
//			return false;
//		}

		if ($diff->days > 0) {
			$result = $this->gateway->refund_transaction($trans_id, $amount_to_tetri);
		} else {
			$result = $this->gateway->reverse_transaction($trans_id, $amount_to_tetri);
		}

		if (isset($result['RESULT']) && $result['RESULT'] == 'OK') {
			return true;
		}
		return false;
	}

  public function redirect_to_payment_form() {
    ?>
    <html>
    <head>
      <title>TBC</title>
      <script type="text/javascript" language="javascript">
        function redirect() {
          document.returnform.submit();
        }
      </script>
    </head>

    <body onLoad="javascript:redirect()">
      <form name="returnform"
        action="<?php echo esc_url(sprintf('https://%s.ufc.ge/ecomm2/ClientHandler', $_GET['merchant_host'])); ?>"
        method="POST">
        <input type="hidden" name="trans_id" value="<?php echo rawurldecode($_GET['transaction_id']); ?>">
        <noscript>
          <center>
            <?php esc_html_e('Please click the submit button below.', 'tbc-gateway-free'); ?><br>
            <input type="submit" name="submit" value="Submit">
          </center>
        </noscript>
      </form>
    </body>
    </html>
    <?php
    exit();
  }
}