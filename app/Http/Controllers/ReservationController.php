<?php

namespace App\Http\Controllers;

use App\Traits\ReservationTrait;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Models\Amenity;
use App\Models\Package;
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
        $reservations = Reservation::where('user_id', Auth::id())->latest()->get();
        return view('guest.reservation', compact('reservations'));
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
        if (empty($room))
        {
            toastr()->info("There's no Available room at the moment");
            return redirect()->back();
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
        if(!$this->check_availability($request)->original['status']){
            toastr()->error("Ops! Looks like your are cheating HAHAHA. You can't do that, STOP!");
            return redirect()->back();
        }
        Session::put('qty', $request->qty);
        Session::put('amenity_id', $request->amenity_id);
        Session::put('payment_method_id', $request->payment_method_id);
        Session::put('date_range', $request->date_range);
        Session::put('room_id', $request->room_id);

        $date_range = explode("-", $request->date_range);
        $arrival_date = Carbon::parse($date_range[0])->format('Y-m-d H:i:s');
        $departure_date = Carbon::parse($date_range[1])->format('Y-m-d H:i:s');

        $start_date = Carbon::createFromFormat('Y-m-d H:i:s', $arrival_date);
        $end_date = Carbon::createFromFormat('Y-m-d H:i:s', $departure_date);
        $length_stay = $start_date->diffInDays($end_date) + 1;

        $payment_method = PaymentMethod::findOrFail(decrypt($request->payment_method_id));
        $room = Room::findOrFail(decrypt($request->room_id));

        if (decrypt($request->payment_method_id) == 1) {
            return redirect()->route('setup_completion');
        } else if (decrypt($request->payment_method_id) == 2) {
            return view('guest.checkout.pay_with_paypal', compact('payment_method', 'room', 'length_stay'));
        } else if (decrypt($request->payment_method_id) == 3) {
            return view('guest.checkout.pay_with_stripe', compact('payment_method', 'room', 'length_stay'));
        } else if (decrypt($request->payment_method_id) == 4) {
            return redirect()->route('paymaya.create_order');
        }
    }

    public function update_reservation(Request $request){
        $date_range = explode("-", $request->date_range);
        $start_date = Carbon::createFromFormat('Y-m-d H:i:s', Carbon::parse($date_range[0])->format('Y-m-d H:i:s'));
        $end_date = Carbon::createFromFormat('Y-m-d H:i:s', Carbon::parse($date_range[1])->format('Y-m-d H:i:s'));

        Reservation::findOrFail(decrypt($request->id))->update([
            'arrival_date' => Carbon::parse($date_range[0])->format('Y-m-d H:i:s'),
            'departure_date' => Carbon::parse($date_range[1])->format('Y-m-d H:i:s')
        ]);

        toastr()->success("Reservation extended successfully");
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function cancel(Request $request)
    {
        Reservation::findOrFail(decrypt($request->id))->update(['request_cancellation' => true, 'cancellation_reason' => $request->reason]);
        toastr()->success("Your cancellation request has been sent. Please wait till your request be approve");
        return redirect()->back();
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
        $length_stay = $start_date->diffInDays($end_date) + 1;
        $total = Room::findOrFail(decrypt($request->room_id))->price * $length_stay;

        if (!Room::findOrFail(decrypt($request->room_id))->is_available) {
            return response()->json([
                'status' => false, 
                'message' => 'The room is under maintenance.',
                'length_stay' => $length_stay,
                'total' => $total
            ]);
        }

        if (Room::findOrFail(decrypt($request->room_id))->max_length_stay < $length_stay) {
            return response()->json([
                'status' => false, 
                'message' => 'You cannot choose higher than the max length of stay.',
                'length_stay' => $length_stay,
                'total' => $total
            ]);
        }

        foreach($reservations as $reservation){
            if (Reservation::whereBetween('arrival_date', [$arrival_date, $departure_date])->count()) {
                return response()->json([
                    'status' => false, 
                    'message' => 'Not Available. The selected date is Closed to Arrival (CTA)',
                    'length_stay' => $length_stay,
                    'total' => $total
                ]);
            }
            
            if (Reservation::whereBetween('departure_date', [$arrival_date, $departure_date])->count()) {
                return response()->json([
                    'status' => false, 
                    'message' => 'Not Available. The selected date is Closed to Departure (CTD)',
                    'length_stay' => $length_stay,
                    'total' => $total
                ]);
            }
            
        }
       
        return response()->json([
            'status' => true, 
            'message' => 'Available', 
            'length_stay' => $length_stay,
            'total' => $total
        ]);
    }

    public function setup_completion(){
        return view('guest.checkout.complete_transaction');
    }

    public function complete_transaction(){
        $date_range = explode("-", Session::get('date_range'));
        $start_date = Carbon::createFromFormat('Y-m-d H:i:s', Carbon::parse($date_range[0])->format('Y-m-d H:i:s'));
        $end_date = Carbon::createFromFormat('Y-m-d H:i:s', Carbon::parse($date_range[1])->format('Y-m-d H:i:s'));

        $new = Reservation::create([
            'invoice_no' => "RSN".date("siHymd"),
            'user_id' => Auth::id(),
            'room_id' => decrypt(Session::get('room_id')),
            'payment_method_id' => decrypt(Session::get('payment_method_id')),
            'total' => $this->compute_total(),
            'arrival_date' => Carbon::parse($date_range[0])->format('Y-m-d H:i:s'),
            'departure_date' => Carbon::parse($date_range[1])->format('Y-m-d H:i:s'),
            'status_id' => 1,
            'length_of_stay' => $start_date->diffInDays($end_date)+1
        ]);

        $qty = Session::get('qty');
        $amenity_id = Session::get('amenity_id');
        if (!empty($amenity_id)) {
            foreach($amenity_id as $id) {
                Package::create([
                    'user_id' => Auth::id(),
                    'amenity_id' => $id,
                    'reservation_id' => $new->id,
                    'qty' => $qty[$id-1],
                    'price' => Amenity::findOrFail($id)->price * $qty[$id-1]
                ]);
            }
        }

        Session::forget('payment_method_id');
        Session::forget('date_range');
        Session::forget('room_id');
        Session::forget('amenity_id');
        Session::forget('qty');

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

    public function manage_reservation(){
        $reservations = Reservation::latest()->get();
        return view('admin.reservation.index', compact('reservations'));
    }

    public function set_status(Request $request){
        Reservation::findOrFail(decrypt($request->id))->update(['status_id' => decrypt($request->status_id)]);
        return response()->json(true);
    }

    public function cancellation_request(){
        $reservations = Reservation::where('request_cancellation', true)->latest()->get();
        return view('admin.reservation.cancellation_request', compact('reservations'));
    }
}
