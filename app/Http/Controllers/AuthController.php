<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\User;
use Auth;

class AuthController extends Controller
{
    public function login(){
    	return view('auth.login');
    }

    public function register(){
        return view('auth.register');
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

        if (Auth::attempt($credentials, $remember_me))
        {
            $request->session()->regenerate();

            toastr()->success("Hi " . Auth::user()->name . ", Welcome back!");
            if (Auth::user()->role_id == 1)
            {
                return redirect('/');
            }
            return redirect()->route('reservation.create');
        }

        toastr()->error("Failed!", "The provided credentials do not match our records.");
        return redirect()->back()->with(['error' => "The provided credentials do not match our records."])->withInput();
    }

    public function register_user(Request $request){
        $validate = Validator::make($request->all(), [
            'name' => ['required', 'regex:/^[\pL\s\-]+$/u', 'max:255'],
            'email' => ['required', 'string', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'alpha_dash'],
            'retype_password' => ['required', 'same:password'],
        ]);

        if ($validate->fails()) {
            toastr()->error($validate->messages()->first());
            return redirect()->back()->withInput();
        }

        $new = User::create([
            'role_id' => 2,
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
        ]);

        Auth::loginUsingId($new->id);

        toastr()->success("Registered successfully");
        return redirect()->route('reservation.create');
    }

    public function admin_login(){
        return view('auth.admin_login');
    }

    public function check_password(Request $request){
        return response()->json(Hash::check($request->password, Auth::user()->password));
    }
}
