<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Content;
use App\Models\Image;

class ContentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contents = Content::all();
        return view('admin.content_management.index', compact('contents'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Content $content)
    {
        if ($request->file('image')) {

            $check = Validator::make(['image' => $request->file('image')], [
                'image' => 'image|mimes:jpeg,png,jpg,gif,svg',
            ]);

            if ($check->fails()){
                toastr()->error($check->messages()->first());
                return redirect()->back()->withInput();
            }
            // This will store the image
            $request->file('image')->store('public/image');
            // This will get the new name
            $hash_name = $request->file('image')->hashName();

            $image = Image::create([
                'hash_name' => $hash_name
            ]);

            if (!empty($content->image)) {
                $content->image->delete();
            }


            $content->update(['image_id' => $image->id, 'default' => false]);
        }

        $content->update([
            'text' => $request->text ? $request->text : NULL,
            'link' => $request->link ? $request->link : NULL,
            'phone' => $request->phone ? $request->phone : NULL,
            'facebook_link' => $request->facebook_link ? $request->facebook_link : NULL,
            'twitter_link' => $request->twitter_link ? $request->twitter_link : NULL,
            'youtube_link' => $request->youtube_link ? $request->youtube_link : NULL,
            'instagram_link' => $request->instagram_link ? $request->instagram_link : NULL
        ]);

        toastr()->success("Content updated successfully");
        return redirect()->back();
    }
}
