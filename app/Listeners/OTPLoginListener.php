<?php

namespace App\Listeners;

use App\Events\OTPLogin;
use App\Notifications\Auth\OtpLogin as AuthOtpLogin;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class OTPLoginListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(OTPLogin $event): void
    {
        $user = $event->user;

        $otp = $event->otp;

        $user->notify(new AuthOtpLogin($otp));
    }
}
