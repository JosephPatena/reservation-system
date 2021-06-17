<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inquiry;
use Auth;

class InquiryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $inquiries = Inquiry::all();
        return view('admin.inquiries.index', compact('inquiries'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Inquiry $inquiry)
    {
        $inquiry->update(['response' => $request->response]);
        toastr()->success("Your response sent successfully.");
        return redirect()->back();
    }

    public function store_inquiry(Request $request){
        $request->request->add(['user_id' => Auth::id()]);
        if ($request->same_as_profile=="on") {
            $request->merge(['same_as_profile' => true]);
        }else{
            $request->merge(['same_as_profile' => false]);
        }

        Inquiry::create($request->all());

        toastr()->success("Your inquiry sent successfully.");
        return redirect()->back();
    }

    public function my_inquiries(){
        $inquiries = Inquiry::where('user_id', Auth::id())->latest()->get();
        return view('guest.inquiries', compact('inquiries'));
    }
}
