<?php

namespace App\PayMaya;

use Aceraven777\PayMaya\PayMayaSDK;
use Aceraven777\PayMaya\API\Customization;

/**
 * 
 */
class MerchantPage
{
    
    public function customizeMerchantPage($public_key, $secret_key, $environment)
    {
        PayMayaSDK::getInstance()->initCheckout($public_key, $secret_key, $environment);

        $shopCustomization = new Customization();
        $shopCustomization->get();

        $shopCustomization->logoUrl = asset('logo.jpg');
        $shopCustomization->iconUrl = asset('favicon.ico');
        $shopCustomization->appleTouchIconUrl = asset('favicon.ico');
        $shopCustomization->customTitle = 'PayMaya Payment Gateway';
        $shopCustomization->colorScheme = '#f3dc2a';

        $shopCustomization->set();
    }
}
