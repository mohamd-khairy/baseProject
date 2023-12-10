<?php

namespace App\Observers;

use App\Models\User;
use Illuminate\Auth\Events\Registered;

class UserObserver
{
    public function created(User $user): void
    {
        try {
            /** event for send verify email to user */
            event(new Registered($user));
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
}
