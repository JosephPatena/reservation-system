<?php

namespace App\PayMaya;

use Aceraven777\PayMaya\PayMayaSDK;
use Aceraven777\PayMaya\API\VoidPayment;

/**
 * 
 */
class VoidPayment
{
    
    public function voidPayment($checkoutId, $public_key, $secret_key, $environment)
    {
        PayMayaSDK::getInstance()->initCheckout($public_key, $secret_key, $environment);

        $voidPayment = new VoidPayment;
        $voidPayment->checkoutId = $checkoutId;
        $voidPayment->reason = 'The item is out of stock.';

        $response = $voidPayment->execute();

        if ($response === false) {
            $error = $voidPayment::getError();
            return redirect()->back()->withErrors(['message' => $error['message']]);
        }

        return $response;
    }
}
