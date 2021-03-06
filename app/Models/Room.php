<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use App\Models\Accomodation;
use App\Models\Reservation;
use App\Models\Image;

class Room extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = [];

    public function images(){
        return $this->hasMany(Image::class);
    }

    public function accomodation(){
        return $this->belongsTo(Accomodation::class, 'accomodation_id');
    }

    public function reservation(){
        return $this->hasMany(Reservation::class);
    }
}
