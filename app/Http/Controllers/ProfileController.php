<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Models\Inquiry;
use App\Models\Image;
use App\Models\User;
use Auth;

class ProfileController extends Controller
{
    public function profile(){

        return view('admin.profile.index');
    }

    public function my_profile(){

        return view('guest.profile');
    }

    public function update_profile(Request $request){
        $email_validation = array('required', 'string', 'max:255', 'unique:users');
        if (Auth::user()->email == $request->email)
        {
            $email_validation = array_diff($email_validation, array('unique:users'));
        }

        $validate = Validator::make($request->all(), [
            'name' => ['required', 'regex:/^[\pL\s\-]+$/u', 'max:255'],
            'email' => $email_validation
        ]);

        if ($validate->fails()) {
            toastr()->error($validate->messages()->first());
            return redirect()->back()->withInput();
        }

        User::findOrFail(decrypt($request->id))->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone ? $request->phone : NULL
        ]);

        if(isset($request->change_pass)){
            $validate = Validator::make($request->all(), [
                'password' => ['required', 'string', 'min:8', 'alpha_dash'],
                'confirm_password' => ['required', 'same:password']
            ]);

            if ($validate->fails()) {
                toastr()->error($validate->messages()->first());
                return redirect()->back()->withInput();
            }

            User::findOrFail(decrypt($request->id))->update([
                'password' => Hash::make($request->password)
            ]);
        }

        if (!empty($request->image)) {
            $check = Validator::make($request->all(), [
                'image' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048|dimensions:min_width=100,min_height=100,max_width=1000,max_height=1000'
            ]);

            if ($check->fails()) {
                toastr()->error($check->messages()->first());
                return redirect()->back()->withInput();
            }

            // This will store the image
            $request->image->store('public/image');
            // This will get the new name
            $hash_name = $request->image->hashName();

            Image::where('user_id', decrypt($request->id))->delete();

            $image = Image::create(['hash_name' => $hash_name, 'user_id' => decrypt($request->id)]);
        }

        toastr()->success("Profile updated successfully");
        return redirect()->back();
    }

    public function seen_notif(Request $request){
        if ($request->type == "reservation") {
            Reservation::where('seen', false)->update(['seen' => true]);
        }else{
            Inquiry::where('seen', false)->update(['seen' => true]);
        }

        return response()->json(true);
    }
}
