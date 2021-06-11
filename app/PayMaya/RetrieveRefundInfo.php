<?php

namespace App\PayMaya;

use Aceraven777\PayMaya\PayMayaSDK;
use Aceraven777\PayMaya\API\RefundPayment;

/**
 * 
 */
class RetrieveRefundInfo
{
    
    public function retrieveRefundInfo($checkoutId, $refundId, $public_key, $secret_key, $environment)
    {
        PayMayaSDK::getInstance()->initCheckout($public_key, $secret_key, $environment);

        $refundPayment = new RefundPayment;
        $refundPayment->checkoutId = $checkoutId;
        $refundPayment->refundId = $refundId;

        $refund = $refundPayment->retrieveInfo();

        if ($refund === false) {
            $error = $refundPayment::getError();
            return redirect()->back()->withErrors(['message' => $error['message']]);
        }

        return $refund;
    }
}
