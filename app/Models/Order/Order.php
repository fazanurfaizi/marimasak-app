<?php

namespace App\Models\Order;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User\User;

class Order extends Model
{
    use HasFactory;

    const WAITING = 'waiting';
    const PROCESS = 'process';
    const DONE = 'done';
    const DENIED = 'denied';

    protected $fillable = [
        'user_id',
        'promo_id',
        'invoice_number',
        'total',
        'status'
    ];

    protected $hidden = [
        'status'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function shipping() {
        return $this->hasOne(Shipping::class, 'order_id', 'id');
    }

    public function orderDetails() {
        return $this->hasMany(OrderDetail::class);
    }
}
