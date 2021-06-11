<?php

namespace App\PayPal;

//1. Import the PayPal SDK client that was created in `Set up Server-Side SDK`.
use App\PayPal\PayPalClient;
use PayPalCheckoutSdk\Orders\OrdersCreateRequest;

class CreateOrder
{

// 2. Set up your server to receive a call from the client
  /**
   *This is the sample function to create an order. It uses the
   *JSON body returned by buildRequestBody() to create an order.
   */
  public static function createOrder($currency, $amount, $client_id, $client_secret)
  {
    $request = new OrdersCreateRequest();
    $request->prefer('return=representation');
    $request->body = self::buildRequestBody($currency, $amount);
   // 3. Call PayPal to set up a transaction
    $client = PayPalClient::client($client_id, $client_secret);
    return $client->execute($request);
    dd("cjkasdf");
  }

    /**
     * Setting up the JSON request body for creating the order with minimum request body. The intent in the
     * request body should be "AUTHORIZE" for authorize intent flow.
     *
     */
    private static function buildRequestBody($currency, $amount)
    {
        return array(
            'intent' => 'CAPTURE',
            'application_context' =>
                array(
                    'return_url' => 'https://example.com/return',
                    'cancel_url' => 'https://example.com/cancel'
                ),
            'purchase_units' =>
                array(
                    0 =>
                        array(
                            'amount' =>
                                array(
                                    'currency_code' => $currency,
                                    'value' => $amount
                                )
                        )
                )
        );
    }
}

?>