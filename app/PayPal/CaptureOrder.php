<?php

namespace App\PayPal;

//1. Import the PayPal SDK client that was created in `Set up Server-Side SDK`.
use App\PayPal\PayPalClient;
use PayPalCheckoutSdk\Orders\OrdersCaptureRequest;

class CaptureOrder
{

  // 2. Set up your server to receive a call from the client
  /**
   *This function can be used to capture an order payment by passing the approved
   *order ID as argument.
   *
   *@param orderId
   *@param debug
   *@returns
   */
  public static function captureOrder($orderId, $client_id, $client_secret)
  {
    $request = new OrdersCaptureRequest($orderId);

    // 3. Call PayPal to capture an authorization
    $client = PayPalClient::client($client_id, $client_secret);
    return $client->execute($request);
  }
}

/**
 *This driver function invokes the captureOrder function with
 *approved order ID to capture the order payment.
 */
?>