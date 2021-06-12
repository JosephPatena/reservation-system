<?php

namespace App\Http\Controllers;

use App\Traits\ReservationTrait;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Models\Room;
use Carbon\Carbon;
use Session;
use Auth;
use PDF;

class ReservationController extends Controller
{
    use ReservationTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id=null)
    {
        if ($id)
        {
            $room = Room::findOrFail($id);
        }
        else
        {
            $room = Room::where('is_available', true)->inRandomOrder()->first();
        }
        return view('guest.booknow', compact('room'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Session::put('payment_method_id', $request->payment_method_id);
        Session::put('date_range', $request->date_range);
        Session::put('room_id', $request->room_id);

        $payment_method = PaymentMethod::findOrFail(decrypt($request->payment_method_id));
        $room = Room::findOrFail(decrypt($request->room_id));

        if (decrypt($request->payment_method_id) == 1) {
            return redirect()->route('setup_completion');
        } else if (decrypt($request->payment_method_id) == 2) {
            return view('guest.checkout.pay_with_paypal', compact('payment_method', 'room'));
        } else if (decrypt($request->payment_method_id) == 3) {
            return view('guest.checkout.pay_with_stripe', compact('payment_method', 'room'));
        } else if (decrypt($request->payment_method_id) == 4) {
            return redirect()->route('paymaya.create_order');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    public function check_availability(Request $request){
        $reservations =  Reservation::where('room_id', decrypt($request->room_id))
                                    ->whereNotIn('status_id', [2, 4])
                                    ->get();
        
        $date_range = explode("-", $request->date_range);
        $arrival_date = Carbon::parse($date_range[0])->format('Y-m-d H:i:s');
        $departure_date = Carbon::parse($date_range[1])->format('Y-m-d H:i:s');

        $start_date = Carbon::createFromFormat('Y-m-d H:i:s', $arrival_date);
        $end_date = Carbon::createFromFormat('Y-m-d H:i:s', $departure_date);

        if (!Room::findOrFail(decrypt($request->room_id))->is_available) {
            return response()->json(['status' => false, 'message' => 'The room is under maintenance.']);
        }

        if (Room::findOrFail(decrypt($request->room_id))->max_length_stay < ($start_date->diffInDays($end_date)+1)) {
            return response()->json(['status' => false, 'message' => 'You cannot choose higher than the max length of stay.']);
        }

        foreach($reservations as $reservation){
            if (Reservation::whereBetween('arrival_date', [$arrival_date, $departure_date])->count()) {
                return response()->json(['status' => false, 'message' => 'Not Available. The selected date is Closed to Arrival (CTA)']);
            }
            
            if (Reservation::whereBetween('departure_date', [$arrival_date, $departure_date])->count()) {
                return response()->json(['status' => false, 'message' => 'Not Available. The selected date is Closed to Departure (CTD)']);
            }
            
        }
       
        return response()->json(['status' => true, 'message' => 'Available']);
    }

    public function setup_completion(){
        return view('guest.checkout.complete_transaction');
    }

    public function complete_transaction(){
        $date_range = explode("-", Session::get('date_range'));
        $start_date = Carbon::createFromFormat('Y-m-d H:i:s', Carbon::parse($date_range[0])->format('Y-m-d H:i:s'));
        $end_date = Carbon::createFromFormat('Y-m-d H:i:s', Carbon::parse($date_range[1])->format('Y-m-d H:i:s'));

        $new = Reservation::create([
            'invoice_no' => date("siHymd"),
            'user_id' => Auth::id(),
            'room_id' => decrypt(Session::get('room_id')),
            'payment_method_id' => decrypt(Session::get('payment_method_id')),
            'total' => $this->compute_total(),
            'arrival_date' => Carbon::parse($date_range[0])->format('Y-m-d H:i:s'),
            'departure_date' => Carbon::parse($date_range[0])->format('Y-m-d H:i:s'),
            'status_id' => 1,
            'length_of_stay' => $start_date->diffInDays($end_date)+1
        ]);

        Session::forget('payment_method_id');
        Session::forget('date_range');
        Session::forget('room_id');

        return redirect()->route('transaction_invoice', encrypt($new->id));
    }

    public function transaction_invoice($id){
        $reservation = Reservation::findOrFail(decrypt($id));
        return view('guest.checkout.transaction_invoice', compact('reservation'));
    }

    public function print_invoice($id){
        $reservation = Reservation::findOrFail(decrypt($id));
        $pdf = PDF::loadView('guest.checkout.pdf', compact('reservation'));
        return $pdf->stream();
    }
}
