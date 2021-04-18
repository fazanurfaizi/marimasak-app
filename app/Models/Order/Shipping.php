<?php

namespace App\Models\Order;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Model\Address\Province;
use App\Model\Address\City;
use App\Model\Address\Disctrict;
use App\Model\Address\Village;

class Shipping extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'address',
        'note',
        'province_id',
        'city_id',
        'district_id',
        'village_id',
        'price'
    ];

    public function order() {
        return $this->hasOne(Order::class);
    }

    public function province() {
        return $this->belongsTo(Pronvice::class);
    }

    public function city() {
        return $this->belongsTo(City::class);
    }

    public function district() {
        return $this->belongsTo(Disctrict::class);
    }

    public function village() {
        return $this->belongsTo(Village::class);
    }
}
