<?php

namespace App\Http\Controllers;

use App\Traits\ReservationTrait;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;
use App\Helpers\Helper;
use App\Models\Room;
use Carbon\Carbon;
use Session;
use Stripe;

class StripeController extends Controller
{
  use ReservationTrait;
  
    public function create_order(){
        try {
            
          \Stripe\Stripe::setApiKey(PaymentMethod::findOrFail(decrypt(Session::get('payment_method_id')))->secret_key);

          header('Content-Type: application/json');

          $paymentIntent = \Stripe\PaymentIntent::create([
            'amount' => round($this->compute_total()) * 100,
            'currency' => Helper::get_owner_currency()->currency->iso_code,
          ]);

          $output = [
            'clientSecret' => $paymentIntent->client_secret
          ];

          echo json_encode($output);
        } catch (Exception $e) {
          http_response_code(500);
          echo json_encode(['error' => $e->getMessage()]);
        }
    }
}
