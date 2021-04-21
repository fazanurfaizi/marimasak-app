<?php

namespace App\Models\Order;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User\User;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'price',
    ];

    protected $appends = [
        'total_items'
    ];

    public function user() {
        return $this->hasOne(User::class);
    }

    public function cartItems() {
        return $this->hasMany(CartItem::class);
    }

    public function getTotalItemsAttribute() {
        return count($this->cartItems);
    }
}
