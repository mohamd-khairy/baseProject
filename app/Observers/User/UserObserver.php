<?php

namespace App\Observers\User;

use App\Models\User;
use Illuminate\Auth\Events\Registered;

class UserObserver
{
    /**
     * @param User $user
     * @return void
     */
    public function created(User $user): void
    {
        try {

            event(new Registered($user));

        } catch (\Throwable $th) {
            //
        }
    }
}
