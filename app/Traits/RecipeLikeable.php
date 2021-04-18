<?php

namespace App\Traits;

use App\Models\Recipe\RecipeLike;
use Illuminate\Support\Facades\Auth;

trait RecipeLikeable {

    public function likes() {
        return $this->morphMany(RecipeLike::class, 'product_likeable');
    }

    public function isLiked() {
        if(Auth::check()) {
            return $this->likes->where('user_id', Auth::user()->id)->isNotEmpty();
        }
        return false;
    }

    public function like($type) {
        if($this->likes()->where('user_id', Auth::user()->id)->doesntExist()) {
            $like = new RecipeLike();
            $like->user_id = Auth::user()->id;
            $like->type = $type;
            return $this->likes()->save($like);
        }
    }

    public function dislike() {
        return $this->likes()->where('user_id', Auth::user()->id)->get()->each->delete();
    }

}
