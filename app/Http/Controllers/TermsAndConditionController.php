<?php

namespace App\Http\Controllers;

use App\Models\TermsAndCondition;
use Illuminate\Http\Request;

class TermsAndConditionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TermsAndCondition  $termsAndCondition
     * @return \Illuminate\Http\Response
     */
    public function show(TermsAndCondition $termsAndCondition)
    {
        return view('terms_and_condition.index', compact('termsAndCondition'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TermsAndCondition  $termsAndCondition
     * @return \Illuminate\Http\Response
     */
    public function edit(TermsAndCondition $termsAndCondition)
    {
        return view('admin.terms_and_condition.index', compact('termsAndCondition'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TermsAndCondition  $termsAndCondition
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TermsAndCondition $termsAndCondition)
    {
        $termsAndCondition->update($request->all());
        toastr()->success("Updated successfully");
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TermsAndCondition  $termsAndCondition
     * @return \Illuminate\Http\Response
     */
    public function destroy(TermsAndCondition $termsAndCondition)
    {
        //
    }
}
