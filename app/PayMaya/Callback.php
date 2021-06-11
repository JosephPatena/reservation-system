<?php

namespace App\PayMaya;

use Illuminate\Http\Request;
use Aceraven777\PayMaya\PayMayaSDK;
use Aceraven777\PayMaya\API\Checkout;
/**
 * 
 */
class Callback
{
    public function callback(Request $request, $public_key, $secret_key, $environment)
    {
        PayMayaSDK::getInstance()->initCheckout($public_key, $secret_key, $environment);

        $transaction_id = $request->get('id');
        if (! $transaction_id) {
            return ['status' => false, 'message' => 'Transaction Id Missing'];
        }
        
        $itemCheckout = new Checkout();
        $itemCheckout->id = $transaction_id;

        $checkout = $itemCheckout->retrieve();

        if ($checkout === false) {
            $error = $itemCheckout::getError();
            return redirect()->back()->withErrors(['message' => $error['message']]);
        }

        return $checkout;
    }
}

