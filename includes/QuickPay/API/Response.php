<?php
/**
 * @file
 * Response class.
 */

namespace QuickPay\API;

/**
 * QuickPay_Response.
 * 
 * @since 1.0.0
 * 
 * @package QuickPay
 * 
 * @category Class
 */
class Response {
  /**
   * HTTP status code of request.
   */
  protected $statusCode;

  /**
   * The headers sent during the request.
   */
  protected $sentHeaders;

  /**
   * The headers received during the request.
   */
  protected $receivedHeaders;

  /**
   * Response body of last request.
   */
  protected $responseData;

  /**
   * Instantiates a new response object.
   *
   * @param int $statusCode
   *        The HTTP status code.
   * @param string $sentHeaders
   *        The headers sent.
   * @param string $receivedHeaders
   *        The headers received.
   * @param string $responseData
   *        The http response body.
   */
  public function __construct($statusCode, $sentHeaders, $receivedHeaders, $responseData) {
    $this->statusCode = $statusCode;
    $this->sentHeaders = $sentHeaders;
    $this->receivedHeaders = $receivedHeaders;
    $this->responseData = $responseData;
  }

  /**
   * Returns the HTTP status code, headers and response body.
   *
   * Usage: list($statusCode, $headers, $response_body) = $response->asRaw().
   *
   * @param bool $keep_authorization_value
   *        Normally the value of the Authorization: header is masked.
   *        True keeps the sent value.
   * @return array
   *         Ex: [integer, string[], string].
   */
  public function asRaw($keep_authorization_value = FALSE) {
    // To avoid unintentional logging of credentials the default
    //is to mask the value of the Authorization: header.
    if ($keep_authorization_value) {
      $sentHeaders = $this->sentHeaders;
    }
    else {
      // Avoid dependency on mbstring.
      $lines = explode("\n", $this->sentHeaders);
      foreach ($lines as &$line) {
        if (strpos($line, 'Authorization: ') === 0) {
          $line = 'Authorization: <hidden by default>';
        }
      }
      $sentHeaders = implode("\n", $lines);
    }

    return [$this->statusCode, [	'sent' => $sentHeaders, 'received' => $this->receivedHeaders], $this->responseData];
  }

  /**
   * Returns the response body as an array.
   *
   * @return array
   *         The result.
   */
  public function asArray() {
    if ($response = json_decode($this->responseData, TRUE)) {
      return $response;
    }

    return array();
  }

  /**
   * Returns the response body as an array.
   *
   * @return array
   *         The result.
   */
  public function asObject() {
    if($response = json_decode($this->responseData)) {
      return $response;
    }

    return new \stdClass();
  }

  /**
   * Returns the httpStatus code.
   *
   * @return int
   *         The status code.
   */
  public function httpStatus() {
    return $this->statusCode;
  }

  /**
   * Checks if the http status code indicates a successful or an error response.
   *
   * @return bool
   *         Was the request successful?
   */
  public function isSuccess() {
    if($this->statusCode > 299) {
      return FALSE;
    }

    return TRUE;
  }

}
