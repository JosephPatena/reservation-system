<?php

namespace App\Helpers;

use App\Models\PaymentMethod;
use App\Models\OwnerCurrency;
use App\Models\Accomodation;
use App\Models\Image;
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

	public static function check_availability($room){
		
	}
}