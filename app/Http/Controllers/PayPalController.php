<?php

namespace App\Http\Controllers;

use App\Traits\ReservationTrait;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;
use App\PayPal\CaptureOrder;
use App\PayPal\CreateOrder;
use App\Helpers\Helper;
use App\Models\Room;
use Carbon\Carbon;
use Session;

class PayPalController extends Controller
{
    use ReservationTrait;
    
    public function create_order(){
        $create_order = new CreateOrder;

        $currency = Helper::get_owner_currency()->currency->iso_code;
        $amount = $this->compute_total();

        $client_id = PaymentMethod::findOrFail(decrypt(Session::get('payment_method_id')))->public_key;
        $client_secret = PaymentMethod::findOrFail(decrypt(Session::get('payment_method_id')))->secret_key;

        return response()->json($create_order->createOrder($currency, $amount, $client_id, $client_secret)->result);
    }

    public function capture_order($order_id){
        $capture_order = new CaptureOrder;

        $client_id = PaymentMethod::findOrFail(decrypt(Session::get('payment_method_id')))->public_key;
        $client_secret = PaymentMethod::findOrFail(decrypt(Session::get('payment_method_id')))->secret_key;
        
        $response = $capture_order->captureOrder($order_id, $client_id, $client_secret)->result;
        if (isset($response->details[0])) {
            return response()->json([$response, 400]);
        }

        return response()->json([$response, 200]);
    }
}
