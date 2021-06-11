<?php

namespace App\PayMaya;

use Aceraven777\PayMaya\PayMayaSDK;
use Aceraven777\PayMaya\API\RefundPayment;

/**
 * 
 */
class RetrieveRefund
{
    
    public function retrieveRefunds($checkoutId, $public_key, $secret_key, $environment)
    {
        PayMayaSDK::getInstance()->initCheckout($public_key, $secret_key, $environment);

        $refundPayment = new RefundPayment;
        $refundPayment->checkoutId = $checkoutId;
        
        $refunds = $refundPayment->retrieve();

        if ($refunds === false) {
            $error = $refundPayment::getError();
            return redirect()->back()->withErrors(['message' => $error['message']]);
        }

        return $refunds;
    }
}
