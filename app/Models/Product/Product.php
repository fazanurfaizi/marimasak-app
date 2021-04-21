<?php

namespace App\Models\Product;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User\User;
use App\Traits\ProductLikeable;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;

class Product extends Model implements Searchable
{
    use HasFactory;
    use SoftDeletes;
    use ProductLikeable;

    protected $fillable = [
        'name',
        'description',
        'price',
        'image',
        'product_type_id',
    ];

    protected $appends = [
        'likes_count',
        'image_url'
    ];

    public function creator() {
        return $this->belongsTo(User::class, 'creator_id');
    }

    public function productType() {
        return $this->belongsTo(ProductType::class);
    }

    public function comments() {
        return $this->hasMany(ProductComment::class);
    }

    public function getLikesCountAttribute() {
        return count($this->likes);
    }

    public function getImageUrlAttribute() {
        return asset('/uploads/products/' . $this->image);
    }

    public function getSearchResult(): SearchResult
    {
        $url = '';

         return new SearchResult(
            $this,
            $this->name,
            $url
         );
    }
}
