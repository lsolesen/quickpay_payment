<?php

class QuickPay_JSON {
	
	/**
	 * error
	 * 
	 * @param  array $message
	 * @return JSON object
	 */
	public static function error( $message ) {
		return json_encode( array(
			'status' => 'error',
			'message' => $message
		) );
	}

	/**
	 * from_array
	 * @param  array $array
	 * @return JSON object
	 */
	public static function from_array( $array ) {
		return json_encode( $array );
	}
}