<?php

namespace App\Http\Controllers;

use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ReportsExport;
use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Models\Room;
use App\Models\User;
use Carbon\Carbon;
use Session;
use PDF;

class ReportsController extends Controller
{

    public function set_date_range(Request $request){
        Session::put('date_range', $request->date_range);
        return response()->json(true);
    }

    private function reservations(){
        if (Session::has('date_range')) {
            $range = explode("-", Session::get('date_range'));
            $from = Carbon::parse($range[0])->format('Y-m-d H:i:s');
            $to = Carbon::parse($range[1])->format('Y-m-d H:i:s');
            $reservations = Reservation::whereBetween('created_at', [$from, $to])->latest()->get();
        }
        else{
            $reservations = Reservation::latest()->get();
        }
        return $reservations;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $reservations = $this->reservations();
        return view('admin.reports.index', compact('reservations'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $reservation = Reservation::findOrFail($id);
        return view('admin.reports.manage', compact('reservation'));
    }

    public function guest($id){
        $guest = User::findOrFail($id);
        $reservations = Reservation::where('user_id', $id)->latest()->get();
        return view('admin.reports.guest', compact('guest', 'reservations'));
    }

    public function room($id){
        $room = Room::findOrFail($id);
        $reservations = Reservation::where('room_id', $id)->latest()->get();
        return view('admin.reports.room', compact('room', 'reservations'));
    }

    public function pdf(){
        $reservations = $this->reservations();
        $pdf = PDF::loadView('admin.reports.pdf', compact('reservations'));
        return $pdf->stream();
    }

    public function export(){
        return Excel::download(new ReportsExport, 'reservations.xlsx');
    }
}
