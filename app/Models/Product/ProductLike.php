<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User\User;

class ProductLike extends Model
{
    use HasFactory;

    protected $fillable = [
        'productlikeable_id',
        'productlikeable_type'
    ];

    public function productlikeable() {
        return $this->morph();
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}
