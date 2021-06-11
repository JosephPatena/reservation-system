<?php

namespace App\PayMaya;

use Aceraven777\PayMaya\PayMayaSDK;
use Aceraven777\PayMaya\API\RefundPayment;
use Aceraven777\PayMaya\Model\Refund\Amount;

/**
 * 
 */
class RefundPayment
{

    public function refundPayment($checkoutId, $public_key, $secret_key, $environment)
    {
        PayMayaSDK::getInstance()->initCheckout($public_key, $secret_key, $environment);

        $refundAmount = new Amount();
        $refundAmount->currency = "PHP";
        $refundAmount->value = 200.22;

        $refundPayment = new RefundPayment;
        $refundPayment->checkoutId = $checkoutId;
        $refundPayment->reason = 'The item is out of stock.';
        $refundPayment->amount = $refundAmount;

        $response = $refundPayment->execute();

        if ($response === false) {
            $error = $refundPayment::getError();
            return redirect()->back()->withErrors(['message' => $error['message']]);
        }

        return $response;
    }
}
