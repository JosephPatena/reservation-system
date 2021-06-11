<?php

namespace App\PayMaya;

use Aceraven777\PayMaya\PayMayaSDK;
use Aceraven777\PayMaya\API\Checkout;
use Aceraven777\PayMaya\Model\Checkout\Item;
use App\Libraries\PayMaya\User as PayMayaUser;
use Aceraven777\PayMaya\Model\Checkout\ItemAmount;
use Aceraven777\PayMaya\Model\Checkout\ItemAmountDetails;

/**
 * 
 */
class InitCheckout
{
    public function checkout($public_key, $secret_key, $environment)
    {
        PayMayaSDK::getInstance()->initCheckout($public_key, $secret_key, $environment);

        $sample_item_name = 'Product 1';
        $sample_total_price = 1000.00;

        $sample_user_phone = '1234567';
        $sample_user_email = 'test@gmail.com';
        
        $sample_reference_number = '1234567890';

        // Item
        $itemAmountDetails = new ItemAmountDetails();
        $itemAmountDetails->tax = "0.00";
        $itemAmountDetails->subtotal = number_format($sample_total_price, 2, '.', '');
        $itemAmount = new ItemAmount();
        $itemAmount->currency = "PHP";
        $itemAmount->value = $itemAmountDetails->subtotal;
        $itemAmount->details = $itemAmountDetails;
        $item = new Item();
        $item->name = $sample_item_name;
        $item->amount = $itemAmount;
        $item->totalAmount = $itemAmount;

        // Checkout
        $itemCheckout = new Checkout();

        $user = new PayMayaUser();
        $user->contact->phone = $sample_user_phone;
        $user->contact->email = $sample_user_email;

        $itemCheckout->buyer = $user->buyerInfo();
        $itemCheckout->items = array($item);
        $itemCheckout->totalAmount = $itemAmount;
        $itemCheckout->requestReferenceNumber = $sample_reference_number;
        $itemCheckout->redirectUrl = array(
            "success" => url('returl-url/success'),
            "failure" => url('returl-url/failure'),
            "cancel" => url('returl-url/cancel'),
        );
        
        if ($itemCheckout->execute() === false) {
            $error = $itemCheckout::getError();
            return ['status' => false, 'message' => $error];
        }

        if ($itemCheckout->retrieve() === false) {
            $error = $itemCheckout::getError();
            return ['status' => false, 'message' => $error];
        }

        return ['status' => true, 'url' => $itemCheckout->url];
    }
}
