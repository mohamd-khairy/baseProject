<?php

namespace App\Jobs;

use App\Mail\Errors\ErrorAlertMail;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class JobDevNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(public array $exception = [])
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $email = User::whereHas('roles', function ($i) {
            $i->where('name', 'admin');
        })->value('email');

        $email = $email ? $email : config('app.admin_email', null);

        if ($email) {
            Mail::to($email)->send(new ErrorAlertMail($this->exception));
        }
    }
}
