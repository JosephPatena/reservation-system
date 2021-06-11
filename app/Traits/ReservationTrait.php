<?php
 
namespace App\Traits;

use App\Models\Room;
use Carbon\Carbon;
use Session;

trait ReservationTrait {

	public function compute_total(){
		$date_range = explode("-", Session::get('date_range'));

        $start_date = Carbon::createFromFormat('Y-m-d H:i:s', Carbon::parse($date_range[0])->format('Y-m-d H:i:s'));
        $end_date = Carbon::createFromFormat('Y-m-d H:i:s', Carbon::parse($date_range[1])->format('Y-m-d H:i:s'));

        $different_days = $start_date->diffInDays($end_date);

        $room = Room::findOrFail(decrypt(Session::get('room_id')));

        return $room->price * ($different_days + 1);
	}
}