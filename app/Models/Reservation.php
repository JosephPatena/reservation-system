<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\PaymentMethod;
use App\Models\Status;
use App\Models\Room;
use App\Models\User;

class Reservation extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function room(){
        return $this->belongsTo(Room::class, 'room_id');
    }

    public function guest(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function payment_method(){
        return $this->belongsTo(PaymentMethod::class, 'payment_method_id');
    }

    public function status(){
        return $this->belongsTo(Status::class, 'status_id');
    }
}
