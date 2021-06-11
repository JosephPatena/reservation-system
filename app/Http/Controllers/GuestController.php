<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class GuestController extends Controller
{
    public function guests(){
        $guest = User::where('role_id', 2)->paginate(20);
    return view('admin.guest.index', compact('guest'));
    }

    public function about(){
        return view('guest.about');
    }

    public function contact(){
        return view('guest.contact');
    }
}
