<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\ProductLikeable;

class ProductComment extends Model
{
    use HasFactory;
    use SoftDeletes;
    use ProductLikeable;

    protected $fillable = [
        'body',
        'user_id',
        'product_id'
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function product() {
        return $this->belongsTo(Product::class);
    }

    public function replies() {
        return $this->hasMany(ProductComment::class, 'parent_id');
    }
}
