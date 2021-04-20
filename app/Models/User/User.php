<?php

namespace App\Models\User;

use Storage;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Passport\HasApiTokens;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;
use App\Models\Recipe\Recipe;
use App\Models\Recipe\RecipeLike;
use App\Models\Recipe\RecipeComment;
use App\Models\Product\Product;
use App\Models\Product\ProductLike;
use App\Models\Product\ProductComment;
use App\Models\Chat\Chatroom;
use App\Models\Chat\Message;
use App\Traits\Followable;

class User extends Authenticatable implements Searchable
{
    // use HasFactory;
    use Notifiable;
    use SoftDeletes;
    use HasApiTokens;
    use Followable;

    const REGISTERED = 'registered';
    const ONLINE = 'online';
    const OFFLINE = 'offline';
    const BANNED = 'banned';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'status',
        'activation_token',
        'avatar'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'activation_token'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The attributes that should be cast to date.
     *
     * @var array
     */
    protected $dates = [
        'deleted_at'
    ];

    /**
     * The attributes that should be appends to eloquent.
     *
     * @var array
     */
    protected $appends = ['avatar_url'];

    public function getAvatarUrlAttribute() {
        return $this->avatar ? Storage::url('avatars/'.$this->id.'/'.$this->avatar) : null;
    }

    public function recipes() {
        return $this->hasMany(Recipe::class);
    }

    public function recipeLikes() {
        return $this->hasMany(RecipeLike::class);
    }

    public function recipeComments() {
        return $this->hasMany(RecipeComment::class);
    }

    public function products() {
        return $this->hasMany(Product::class);
    }

    public function productLikes() {
        return $this->hasMany(ProductLike::class);
    }

    public function productComments() {
        return $this->hasMany(ProductComment::class);
    }

    public function chatrooms() {
        return $this->hasMany(Chatroom::class, 'owner_id');
    }

    public function messages() {
        return $this->hasMany(Message::class);
    }

    public function getSearchResult(): SearchResult
    {
        $url = '';

        return new SearchResult($this, $this->name, $url);
    }

    /**
     * A user can be MEMBER of many chat rooms
     *
     * @return object members
     */
    public function members() {
        return $this->belongsToMany(Chatroom::class, 'room_user', 'user_id', 'room_id')
            ->withTimestamps();
    }

    /**
     * Check if user owns a certain roo
     *
     * @param   Chatroom    $room
     *
     * @return  boolean
     */
    public function isOwner(Chatroom $room) {
        return $this->id === $room->owner_id;
    }

    /**
     * Check if user is Member of a certain room
     *
     * @param Room $room Room object model
     *
     * @return boolean
     */
    public function isMemberOf($room_id)
    {
        return $this->members->contains('id', $room_id);
    }

}
