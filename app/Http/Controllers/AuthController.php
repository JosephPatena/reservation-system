<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class AuthController extends Controller
{
    public function login(){
    	return view('auth.login');
    }

    public function logout(Request $request){
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function authenticate(Request $request){
    	$remember_me = isset($request->remember_me) ? true : false;
    	$credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials, $remember_me)) {
            $request->session()->regenerate();

            toastr()->success("Hi " . Auth::user()->first_name . ", Welcome back!");
            return redirect()->back();
        }

        toastr()->error("Failed!", "The provided credentials do not match our records.");
        return redirect()->back()->with(['error' => "The provided credentials do not match our records."])->withInput();
    }
}
