<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Currencies;

class OwnerCurrency extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function currency(){
        return $this->belongsTo(Currencies::class, 'currency_id');
    }
}
