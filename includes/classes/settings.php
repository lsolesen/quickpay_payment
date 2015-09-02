 <?php

 class QuickpayPayment_Settings {

 	protected $options;
 	protected $gateway_name;
	protected $merchant;
	protected $agreement_id;
	protected $agreement_apikey;
	protected $agreement_privatekey;
	protected $api_apikey;
	protected $payment_methods;
	protected $language;
	protected $autocapture;
	protected $autofee;
	protected $branding_id;

 	public function __construct( $settings = array() ) {
 		$this->options = array();

 		$this->set('gateway_name');
 		$this->set('merchant');
 		$this->set('agreement_id');
 		$this->set('agreement_apikey');
 		$this->set('agreement_privatekey');
 		$this->set('api_apikey');
 		$this->set('payment_methods');
 		$this->set('language');
 		$this->set('autocapture');
 		$this->set('autofee');
 		$this->set('branding_id');
 	}


 	/**
 	 * set
 	 *
 	 * Fast way of setting an options property
 	 * 
 	 * @param string $key 
 	 */
 	private function set($key) {
 		if( isset( $this->options[$key] ) ) {
 			$this->$key = $this->options[$key];
 		} 
 	}


	/**
	 * get_languages
	 * 
	 * returns languages supported in the QuickPay manager
	 * 
	 * @return [array] [the languages]
	 */
	protected static function get_languages() {
		return array(
			'da' => t('Danish'),
			'de' => t('German'),
			'en' => t('English'),
			'fo' => t('Faeroese'),
			'fr' => t('French'),
			'gl' => t('Greenlandish'),
			'it' => t('Italian'),
			'no' => t('Norwegian'),
			'nl' => t('Dutch'),
			'pl' => t('Polish'),
			'se' => t('Swedish'),
		);
	}


	/**
	 * get_country_code 
	 * 
	 * returns the language code as a string
	 * 
	 * @param  string $langcode - language code in Drupal format
	 * @return string - the language code
	 */
	protected static function get_country_code($langcode) {
		$langcodes = array(
			'da' => 'da',
			'de' => 'de',
			'en' => 'en',
			'fo' => 'fo',
			'fr' => 'fr',
			'kl' => 'gl',
			'it' => 'it',
			'nb' => 'no',
			'nn' => 'no',
			'nl' => 'nl',
			'pl' => 'pl',
			'sv' => 'se',
		);

		return isset($langcodes[$langcode]) ? $langcodes[$langcode] : 'en';
	}


	/**
	 * settings_form 
	 * 
	 * returns all the settings fields
	 *
	 * @param  array  $settings
	 * @return array - the settings array
	 */
	public static function settings_form($settings = array()) {
		$settings += array(
			'gateway_name' => t('Credit card'),
			'merchant' => '',
			'agreement_id' => '',
			'agreement_apikey' => '',
			'agreement_privatekey' => '',
			'api_apikey' => '',
			'payment_methods' => array(),
			'language' => LANGUAGE_NONE,
			'autocapture' => FALSE,
			'autofee' => FALSE,
			'branding_id' => '',
		);

		/** Gateway name **/
		$form['gateway_name'] = array(
			'#type' => 'textfield',
			'#title' => t('Gateway Name'),
			'#description' => t('The name of the gateway that is presented to the customers on checkout.'),
			'#default_value' => $settings['gateway_name'],
			'#required' => TRUE,
		);		

		/**  Merchant  **/
		$form['merchant'] = array(
			'#type' => 'textfield',
			'#title' => t('Merchant ID'),
			'#description' => t('Your Payment Window agreement merchant id. Found in the "Integration" tab inside the QuickPay manager.'),
			'#default_value' => $settings['merchant'],
			'#required' => TRUE,
		);

		/**  Payment Window  **/
		$form['agreement_id'] = array(
			'#type' => 'textfield',
			'#title' => t('Payment Window - Agreement ID'),
			'#description' => t('Your Payment Window agreement id. Found in the "Integration" tab inside the QuickPay manager.'),
			'#default_value' => $settings['agreement_id'],
			'#required' => TRUE,
		);

		$form['agreement_apikey'] = array(
			'#type' => 'textfield',
			'#title' => t('Payment Window - API key'),
			'#description' => t('Your Payment Window agreement API key. Found in the "Integration" tab inside the QuickPay manager.'),
			'#default_value' => $settings['agreement_apikey'],
			'#required' => TRUE,
		);

		$form['agreement_privatekey'] = array(
			'#type' => 'textfield',
			'#title' => t('Payment Window - Private key'),
			'#description' => t('Your Payment Window agreement private key. Found in the "Integration" tab inside the QuickPay manager.'),
			'#default_value' => $settings['agreement_privatekey'],
			'#required' => TRUE,
		);


		/**  API setup  **/
		$form['api_apikey'] = array(
			'#type' => 'textfield',
			'#title' => t('API User - API key'),
			'#description' => t('Your API User\'s key. Create a separate API user in the "Users" tab inside the QuickPay manager.'),
			'#default_value' => $settings['api_apikey'],
			'#required' => TRUE,
		);


		/**  Extra Settings  **/
		$form['branding_id'] = array(
			'#type' => 'textfield',
			'#title' => t('Branding ID'),
			'#description' => t('Leave empty if you have no custom branding options'),
			'#default_value' => $settings['branding_id'],
		);

		$form['payment_methods'] = array(
			'#type' => 'checkboxes',
			'#title' => t('Payment Methods'),
			'#options' => self::payment_method_options(),
			'#description' => t('Recommended: creditcard. Type in the cards you wish to accept (comma separated). See the valid payment types here: <b>http://tech.quickpay.net/appendixes/payment-methods/</b>'),
			'#default_value' => $settings['payment_methods'],
		);

		$languages = self::get_languages() + array(LANGUAGE_NONE => t('Language of the user'));
		$form['language'] = array(
			'#type' => 'select',
			'#title' => t('Language'),
			'#description' => t('The language for the credit card form.'),
			'#options' => $languages,
			'#default_value' => $settings['language'],
		);

		$form['autocapture'] = array(
			'#type' => 'checkbox',
			'#title' => t('Autocapture'),
			'#description' => t('Automatically capture payments.'),
			'#default_value' => $settings['autocapture'],
		);

		$form['autofee'] = array(
			'#type' => 'checkbox',
			'#title' => t('Autofee'),
			'#description' => t('If enabled, the fee charged by the acquirer will be calculated and added to the transaction amount.'),
			'#default_value' => $settings['autofee'],
		);

		return $form;
	}


	/**
	 * payment_method_options 
	 *
	 * Return an array of possible payment options
	 * 
	 * @return array
	 */
	public static function payment_method_options() {
		// Available methods
		$payment_methods = quickpay_payment_cards();

		// Prepare options array
		$options = array();

		// Populate options array with payment methods
		foreach( $payment_methods as $key => $value ) {
			$options[$key] = sprintf('<img class="quickpay-card-icon" src="%s" title="%s" /> %2$s', $value['image'], $value['name']);
		}

		return $options;
	}
 }