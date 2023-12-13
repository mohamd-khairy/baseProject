<?php

namespace App\Listeners;

use App\Events\ErrorAlertEvent;
use App\Jobs\JobDevNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ErrorAlertListener
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
    public function handle(ErrorAlertEvent $event): void
    {
        // Dispatch Job and continue
        dispatch((new JobDevNotification($event->exception))->delay(5));
    }
}
