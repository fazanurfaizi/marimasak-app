<?php

namespace App\Models\Product;

use Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductPhoto extends Model
{
    use HasFactory;

    protected $appends = [
        'photo_url'
    ];

    public function product() {
        return $this->belongsTo(Product::class);
    }

    public function getPhotoUrlAttribute() {
        return Storage::url('product/' . $this->unique_hash . '/' . $this->photo);
    }
}
