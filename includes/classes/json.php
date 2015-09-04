<?php
/**
 * @file
 * QuickpayPayment_JSON class.
 */

/**
 * QuickpayPayment_JSON.
 *
 * @since 1.0.0
 *
 * @package QuickPay
 *
 * @category Class
 */
class QuickpayPayment_JSON {

  /**
   * Returns an error response object.
   *
   * @param  string $message
   *         The error message.
   *
   * @return object
   *         JSON object.
   */
  public static function error($message) {
    return json_encode(array(
      'status' => 'error',
      'message' => $message,
    ));
  }

  /**
   * from_array.
   *
   * @return object
   *         JSON object.
   */
  public static function from_array($array) {
    return json_encode($array);
  }
}