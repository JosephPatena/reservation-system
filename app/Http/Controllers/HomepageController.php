<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;

class HomepageController extends Controller
{
    public function admin_homepage(){
        $rooms = Room::all();
    	return view('admin.index', compact('rooms'));
    }

    public function guest_homepage(){
        $room = Room::where('is_available', true)->inRandomOrder()->first();
    	return view('guest.index', compact('room'));
    }
}
