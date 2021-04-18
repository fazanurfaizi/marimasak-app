<?php

namespace App\Traits;

use App\Models\Product\ProductPhoto;
use Illuminate\Support\Facades\Auth;

trait ProductPhotoable {

    public function photos() {
        return $this->morphMany(ProductPhoto::class, 'product_photoable');
    }

}
