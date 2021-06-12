<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Accomodation;
use Illuminate\Support\Arr;
use App\Models\Image;
use App\Models\Room;
use Auth;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $accomodation = Accomodation::all();
        $rooms = Room::all();
        return view('admin.room.index', compact('accomodation', 'rooms'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $accomodation = Accomodation::all();
        return view('admin.room.create', compact('accomodation'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $check = Validator::make($request->all(), [
            'no' => ['required'],
            'name' => ['required'],
            'description' => ['required'],
            'accomodation_id' => ['required'],
            'max_guest' => ['required'],
            'price' => ['required'],
            'no_of_room' => ['required'],
            'max_length_stay' => ['required'],
        ]);

        if ($check->fails()) {
            toastr()->error($check->messages()->first());
            return redirect()->back()->withInput();
        }

        if (!$this->check_images($request->file('photos'))) {
            toastr()->error("Please select at least one image before proceeding.");
            return redirect()->back()->withInput();
        }

        $new = Room::create([
            'no' => $request->no,
            'name' => $request->name,
            'description' => $request->description,
            'accomodation_id' => $request->accomodation_id,
            'max_guest' => $request->max_guest,
            'price' => $request->price,
            'no_of_room' => $request->no_of_room,
            'max_length_stay' => $request->max_length_stay,
            'is_available' => $request->is_available ? true : false
        ]);

        foreach($request->file('photos') as $image){
            $check = Validator::make(['image' => $image], [
                'image' => 'image|mimes:jpeg,png,jpg,gif,svg',
            ]);

            if ($check->fails()){
                continue;
            }
            // This will store the image
            $image->store('public/image');
            // This will get the new name
            $hash_name = $image->hashName();

            Image::create([
                'hash_name' => $hash_name,
                'room_id' => $new->id
            ]);
        }

        toastr()->success('Room added successfully.');
        return redirect()->back();
    }

    private function check_images($images){
        foreach($images as $image)
        {
            $check = Validator::make(['image' => $image], [
                'image' => 'image|mimes:jpeg,png,jpg,gif,svg',
            ]);

            if (!$check->fails()){
                return true;
            }
        }

        return false;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Room $room)
    {
        $accomodation = Accomodation::all();
        return view('admin.room.manage', compact('room', 'accomodation'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Room $room)
    {
        $check = Validator::make($request->all(), [
            'no' => ['required'],
            'name' => ['required'],
            'description' => ['required'],
            'accomodation_id' => ['required'],
            'max_guest' => ['required'],
            'price' => ['required'],
            'no_of_room' => ['required'],
            'max_length_stay' => ['required'],
        ]);

        if ($check->fails()) {
            toastr()->error($check->messages()->first());
            return redirect()->back()->withInput();
        }

        $room->update([
            'no' => $request->no,
            'name' => $request->name,
            'description' => $request->description,
            'accomodation_id' => $request->accomodation_id,
            'max_guest' => $request->max_guest,
            'price' => $request->price,
            'no_of_room' => $request->no_of_room,
            'max_length_stay' => $request->max_length_stay,
            'is_available' => $request->is_available ? true : false
        ]);

        toastr()->success('Room updated successfully.');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function store_image(Request $request){

        if (!$this->check_images($request->file('photos'))) {
            toastr()->error("Please select at least one image before proceeding.");
            return redirect()->back()->withInput();
        }

        foreach($request->file('photos') as $image){
            $check = Validator::make(['image' => $image], [
                'image' => 'image|mimes:jpeg,png,jpg,gif,svg',
            ]);

            if ($check->fails()){
                continue;
            }
            // This will store the image
            $image->store('public/image');
            // This will get the new name
            $hash_name = $image->hashName();

            Image::create([
                'hash_name' => $hash_name,
                'room_id' => $request->room_id
            ]);
        }

        toastr()->success("Image saved successfully.");
        return redirect()->back();
    }

    public function delete_image(Request $request){
        Image::destroy(decrypt($request->id));

        toastr()->success("Image deleted successfully.");
        return redirect()->back();
    }

    public function room_type($accomodation_id)
    {
        $rooms = Room::where('accomodation_id', $accomodation_id)->get();
        return view('guest.room', compact('rooms'));
    }

    public function room()
    {
        $rooms = Room::all();
        return view('guest.room', compact('rooms'));
    }
}
