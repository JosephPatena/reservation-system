<?php

namespace App\PayMaya;

use Aceraven777\PayMaya\PayMayaSDK;
use Aceraven777\PayMaya\API\Webhook;

/**
 * 
 */
class Webhooks
{
    
    public function setupWebhooks($public_key, $secret_key, $environment)
    {
        PayMayaSDK::getInstance()->initCheckout($public_key, $secret_key, $environment);

        $this->clearWebhooks();

        $successWebhook = new Webhook();
        $successWebhook->name = Webhook::CHECKOUT_SUCCESS;
        $successWebhook->callbackUrl = url('callback/success');
        $successWebhook->register();

        $failureWebhook = new Webhook();
        $failureWebhook->name = Webhook::CHECKOUT_FAILURE;
        $failureWebhook->callbackUrl = url('callback/error');
        $failureWebhook->register();

        $dropoutWebhook = new Webhook();
        $dropoutWebhook->name = Webhook::CHECKOUT_DROPOUT;
        $dropoutWebhook->callbackUrl = url('callback/dropout');
        $dropoutWebhook->register();
    }

    private function clearWebhooks()
    {
        $webhooks = Webhook::retrieve()
;        foreach ($webhooks as $webhook) {
            $webhook->delete();
        }
    }
}
