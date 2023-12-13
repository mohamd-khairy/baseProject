<?php

namespace App\Exceptions;

use App\Events\ErrorAlertEvent;
use App\Jobs\JobDevNotification;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {

            //send mail to admin with this exception
            $this->reportAdmin($e);
        });

        $this->renderable(function (AuthenticationException $e, $request) {

            //send mail to admin with this exception
            $this->reportAdmin($e);

            return failResponse($e->getMessage(), 401);
        });

        $this->renderable(function (HttpException $e, $request) {

            //send mail to admin with this exception
            $this->reportAdmin($e);

            return failResponse($e->getMessage(), 400);
        });
    }


    protected function reportAdmin(Throwable $e)
    {

        try {
            // Create Notification Data
            $exception = handleException($e);

            event(new ErrorAlertEvent($exception));
        } catch (\Throwable $th) {
            //
        }
    }
}
