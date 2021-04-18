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
        'unit',
        'price',
        'thumbnail',
        'product_type_id',
    ];

    public function creator() {
        return $this->belongsTo(User::class, 'creator_id');
    }

    public function productType() {
        return $this->belognsTo(ProductType::class);
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
