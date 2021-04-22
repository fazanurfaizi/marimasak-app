<?php

namespace App\Observers;

use App\Models\User\User;
use App\Models\Order\Cart;

class UserObserver
{
    /**
     * Handle the User "created" event.
     *
     * @param  \App\Models\User\User  $user
     * @return void
     */
    public function created(User $user)
    {
        Cart::create([
            'user_id' => $user->id,
            'price' => 0
        ]);
    }

    /**
     * Handle the User "updated" event.
     *
     * @param  \App\Models\User\User  $user
     * @return void
     */
    public function updated(User $user)
    {
        //
    }

    /**
     * Handle the User "deleted" event.
     *
     * @param  \App\Models\User\User  $user
     * @return void
     */
    public function deleted(User $user)
    {
        //
    }

    /**
     * Handle the User "restored" event.
     *
     * @param  \App\Models\User\User  $user
     * @return void
     */
    public function restored(User $user)
    {
        //
    }

    /**
     * Handle the User "force deleted" event.
     *
     * @param  \App\Models\User\User  $user
     * @return void
     */
    public function forceDeleted(User $user)
    {
        //
    }
}
