<?php

namespace App\Models\Order;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'promo_id',
        'total',
        'status'
    ];

    protected $hidden = [
        'status'
    ];

    public function shipping() {
        return $this->hasOne(Shipping::class, 'order_id', 'id');
    }
}
