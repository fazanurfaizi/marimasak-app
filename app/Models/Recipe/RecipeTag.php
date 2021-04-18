<?php

namespace App\Models\Recipe;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Tag;

class RecipeTag extends Model
{
    use HasFactory;

    protected $fillable = [
        'recipe_id',
        'tag_id'
    ];

    public function recipe() {
        return $this->belongsTo(Recipe::class);
    }

    public function tag() {
        return $this->belongsTo(Tag::class);
    }
}
