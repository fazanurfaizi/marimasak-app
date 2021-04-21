<?php

namespace App\Models\Recipe;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User\User;
use App\Traits\RecipeLikeable;

class Recipe extends Model
{
    use HasFactory;
    use RecipeLikeable;

    public $fillable = [
        'name',
        'description',
        'materials',
        'methods',
        'thumbnail',
        'user_id'
    ];

    protected $appends = [
        'likes_count',
        'thumbnail_url'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function comments() {
        return $this->hasMany(RecipeComment::class)->orderBy('created_at', 'DESC');
    }

    public function likes() {
        return $this->hasMany(RecipeLike::class);
    }

    public function tags() {
        return $this->hasMany(RecipeTag::class);
    }

    public function getLikesCountAttribute() {
        return count($this->likes);
    }

    public function getThumbnailUrlAttribute() {
        return asset('uploads/recipes/' . $this->thumbnail);
    }

}
