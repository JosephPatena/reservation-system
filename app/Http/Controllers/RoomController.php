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
            'room_no' => ['required'],
            'name' => ['required'],
            'description' => ['required'],
            'accomodation_id' => ['required'],
            'no_of_person' => ['required'],
            'price' => ['required'],
            'no_of_room' => ['required']
        ]);

        if ($check->fails()) {
            toastr()->error($check->messages()->first());
            return redirect()->back()->withInput();
        }

        ($request->is_available=="on") ? ($request->is_available=true) : ($request->is_available=false);

        $new = Room::create([
            'room_no' => $request->room_no,
            'name' => $request->name,
            'description' => $request->description,
            'accomodation_id' => $request->accomodation_id,
            'no_of_person' => $request->no_of_person,
            'price' => $request->price,
            'no_of_room' => $request->no_of_room
        ]);

        if (!is_null($request->file('photos')) && count($request->file('photos')) && !empty($new))
        {

            for ($i=0; $i < count($request->file('photos')); $i++) { 
                $check = Validator::make(['photos' => $request->file('photos')[$i]], [
                    'photos' => 'image|mimes:jpeg,png,jpg,gif,svg'
                ]);
                if ($check->fails()){
                    toastr()->error("Some image cannot be saved because of unsupported format.");
                }else{

                    // This will store the image
                    $request->file('photos')[$i]->store('public/image');
                    // This will get the new name
                    $hash_name = $request->file('photos')[$i]->hashName();

                    Image::create([
                        'hash_name' => $hash_name,
                        'room_id' => $new->id
                    ]);
                }
            }
        }

        toastr()->success('Room added successfully.');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Room $room)
    {
        return view('admin.room.manage', compact('room'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
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
    public function update(Request $request, $id)
    {
        //
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
}
