<?php

namespace App\Models\Order;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User\User;

class PromoUser extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'promo_id',
        'is_used'
    ];

    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function promo() {
        return $this->belongsTo(Promo::class, 'promo_id', 'id');
    }
}
