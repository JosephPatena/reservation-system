<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Image;

class Content extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function image(){
        return $this->belongsTo(Image::class, 'image_id');
    }
}
