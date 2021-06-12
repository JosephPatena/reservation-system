<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PaymentMethod;

class BillingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $payment_method = PaymentMethod::all();
        return view('admin.billing.index', compact('payment_method'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function enable_disable_billing(Request $request)
    {

        PaymentMethod::findOrFail($request->id)->update(['is_available' => ($request->status=="true" ? true : false)]);

        return response()->json(true);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        PaymentMethod::findOrFail(decrypt($id))
                    ->update([
                        'public_key' => $request->public_key,
                        'secret_key' => $request->secret_key,
                        'is_available' => $request->is_available=="on" ? true : false
                    ]);

        toastr()->success("Your billing credentials saved successfully.");
        return redirect()->back();

    }
}
