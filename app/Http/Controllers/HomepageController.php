<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomepageController extends Controller
{
    public function admin_homepage(){
    	return view('admin.homepage');
    }

    public function guest_homepage(){
    	return view('guest.homepage');
    }
}
