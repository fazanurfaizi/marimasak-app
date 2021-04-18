<?php

namespace App\Models\Recipe;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User\User;

class RecipeLike extends Model
{
    use HasFactory;

    const LIKE = 'like';
    const LOVE = 'love';
    const CARE = 'care';
    const HAHA = 'haha';
    const WOW = 'wow';
    const SAD = 'sad';
    const ANGRY = 'angry';

    protected $fillable = [
        'user_id',
        'recipe_id',
        'type'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function recipe() {
        return $this->belongsTo(Recipe::class);
    }
}
