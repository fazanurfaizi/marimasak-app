<?php

namespace App\Traits;

use App\Models\Product\ProductLike;
use Illuminate\Support\Facades\Auth;

trait ProductLikeable {

    public function likes() {
        return $this->hasMany(ProductLike::class);
    }

    public function isLiked() {
        if(Auth::check()) {
            return $this->likes->where('user_id', Auth::user()->id)->isNotEmpty();
        }
        return false;
    }

    public function like($type) {
        if($this->likes()->where('user_id', Auth::user()->id)->doesntExist()) {
            $like = new ProductLike();
            $like->user_id = Auth::user()->id;
            $like->type = $type;
            return $this->likes()->save($like);
        }
    }

    public function dislike() {
        return $this->likes()->where('user_id', Auth::user()->id)->get()->each->delete();
    }

}
