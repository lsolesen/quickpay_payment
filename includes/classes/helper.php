<?php

class QuickPay_Helper {
	/**
	* order_number_standardize function.
	*
	* Returns an order number which is at least 4 digits which is required by QuickPay
	*
	* @access public static 
	* @return string
	*/	
	public static function order_number_standardize( $order_number ) {
		return str_pad( $order_number , 4, 0, STR_PAD_LEFT );
	}

	
	/**
	* price_multiply function.
	*
	* Returns the price with no decimals. 10.10 returns as 1010.
	*
	* @access public static
	* @return integer
	*/
	public static function price_multiply( $price ) {
		return number_format( $price * 100, 0, '', '' );
	}


	/**
	* price_normalize function.
	*
	* Returns the price with decimals. 1010 returns as 10.10.
	*
	* @access public static
	* @return float
	*/
	public static function price_normalize( $price ) {
		return number_format( $price / 100, 2, '.', '' );
	}


	/**
	* revision function.
	*
	* Returns the proper revision log message depending on the param
	*
	* @access public static
	* @param string $status order status
	* @return string
	*/
	public static function revision( $status ) {
		$log_message = 'QuickPay: ';

		switch( $status )
		{
			case 'cancel':
				$log_message .= t('Transaction canceled.');
				break;
			case 'authorize': 
				$log_message .= t('Transaction authorized.');
				break;
			case 'capture':
				$log_message .= t('Transaction captured.');
				break;
		}

		return $log_message;
	}
}