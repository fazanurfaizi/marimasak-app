<?php

namespace App\Models\Recipe;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User\User;

class Recipe extends Model
{
    use HasFactory;

    public $fillable = [
        'name',
        'description',
        'materials',
        'methods',
        'thumbnail',
        'user_id'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function comments() {
        return $this->hasMany(RecipeComment::class);
    }

    public function likes() {
        return $this->hasMany(RecipeLike::class);
    }

    public function tags() {
        return $this->hasMany(RecipeTag::class);
    }
}
