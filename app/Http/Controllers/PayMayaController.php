'<?php

namespace App\Http\Controllers;

use Aceraven777\PayMaya\Model\Checkout\ItemAmountDetails;
use Aceraven777\PayMaya\Model\Checkout\ItemAmount;
use App\Libraries\PayMaya\User as PayMayaUser;
use Aceraven777\PayMaya\Model\Checkout\Item;
use Aceraven777\PayMaya\API\Checkout;
use Aceraven777\PayMaya\PayMayaSDK;
use App\Traits\ReservationTrait;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;
use App\Helpers\Helper;
use App\Models\Room;
use Carbon\Carbon;
use Session;
use Auth;

class PayMayaController extends Controller
{
    use ReservationTrait;
    
    public function create_order(){

        $public_key = PaymentMethod::findOrFail(decrypt(Session::get('payment_method_id')))->public_key;
        $secret_key = PaymentMethod::findOrFail(decrypt(Session::get('payment_method_id')))->secret_key;
        $environment = 'SANDBOX';

        PayMayaSDK::getInstance()->initCheckout($public_key, $secret_key, $environment);
        
        $amount = $this->compute_total();
        // Item
        $itemAmountDetails = new ItemAmountDetails();
        $itemAmountDetails->subtotal = number_format($amount, 2, '.', '');
        $itemAmount = new ItemAmount();
        $itemAmount->currency = Helper::get_owner_currency()->currency->iso_code;
        $itemAmount->value = $amount;
        $itemAmount->details = $itemAmountDetails;
        $item = new Item();
        $item->name = Room::findOrFail(decrypt(Session::get('room_id')))->accomodation->name;
        $item->amount = $itemAmount;
        $item->totalAmount = $itemAmount;

        // Checkout
        $itemCheckout = new Checkout();

        $user = new PayMayaUser();
        $user->contact->phone = Auth::user()->phone;
        $user->contact->email = Auth::user()->email;

        $itemCheckout->buyer = $user->buyerInfo();
        $itemCheckout->items = array($item);
        $itemCheckout->totalAmount = $itemAmount;
        $itemCheckout->requestReferenceNumber = "RSN".date("siHymd");
        $itemCheckout->redirectUrl = array(
            "success" => route('setup_completion'),
            "failure" => route('reservation.create'),
            "cancel" => route('reservation.create'),
        );
        
        if ($itemCheckout->execute() === false) {
            $error = $itemCheckout::getError();
            
            toastr()->error($error['message']);
            return redirect()->back();
        }

        if ($itemCheckout->retrieve() === false) {
            $error = $itemCheckout::getError();
            
            toastr()->error($error['message']);
            return redirect()->back();
        }

        return redirect($itemCheckout->url);
    }
}
