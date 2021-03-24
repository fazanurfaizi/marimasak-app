<?php

namespace App\Models\Invoice;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;

class Invoice extends Model
{
    use HasFactory;

    public function getSearchResult(): SearchResult
    {
        $url = route('blogPost.show', $this->slug);

         return new \Spatie\Searchable\SearchResult(
            $this,
            $this->title,
            $url
         );
     }
}
