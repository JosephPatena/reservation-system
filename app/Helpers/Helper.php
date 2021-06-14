<?php

namespace App\Helpers;

use App\Models\PaymentMethod;
use App\Models\OwnerCurrency;
use App\Models\Accomodation;
use App\Models\Reservation;
use App\Models\Inquiry;
use App\Models\Image;
use App\Models\Room;
use App\Models\User;
use Carbon\Carbon;
use Auth;

class Helper
{
	public static function get_user(){
		return Auth::user();
	}

	public static function get_accomodation(){
		return Accomodation::all();
	}

	public static function get_payment_method(){
		return PaymentMethod::all();
	}

	public static function get_owner_currency(){
		return OwnerCurrency::first();
	}

	public static function check_availability($room_id){

		if (!Room::findOrFail($room_id)->is_available) {
			return "bg-maroon";
		} elseif(Reservation::where('status_id', 3)->where('room_id', $room_id)->count()) {
			return "bg-green";
		} elseif (Reservation::where('status_id', 1)->where('room_id', $room_id)->count()) {
			return "bg-aqua";
		} elseif (Reservation::where('status_id', 2)->where('room_id', $room_id)->whereDate('created_at', '>', Carbon::today()->format('Y-m-d'))->count()) {
			return "bg-red";
		} elseif (Reservation::where('status_id', 4)->where('room_id', $room_id)->count()) {
			return "bg-yellow";
		} else {
			return "bg-blue";
		}
		
	}

	public static function get_reservation(){
		return Reservation::get();
	}

	public static function get_guest(){
		return User::where('role_id', 2)->get();
	}

	public static function get_room(){
		return Room::get();
	}

	public static function get_inquiries(){
		return Inquiry::get();
	}
}