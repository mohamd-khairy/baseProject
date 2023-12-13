<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\SendVerificationRequest;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Throwable;

class VerificationController extends Controller
{
    /**
     * @param SendVerificationRequest $request
     * @return JsonResponse
     */
    public function resend(SendVerificationRequest $request): JsonResponse
    {
        $user = User::where('email', $request->email)->first();

        if (!$user->hasVerifiedEmail()) {

            try {
                event(new Registered($user));

                return successResponse(message: 'Verify email send successfully');
            } catch (Throwable $th) {
                logError($th);

                return failResponse(message: 'Error In sending email, try again');
            }
        }

        return failResponse('email verified');
    }

    /**
     * @param User $user
     * @return JsonResponse|RedirectResponse|Redirector
     */
    public function verify(User $user): JsonResponse|RedirectResponse|Redirector
    {
        if (!$user->email_verified_at) {

            if ($user->update(['email_verified_at' => now()])) {
                return request()?->wantsJson()
                    ? successResponse(message: 'Verify email successfully')
                    : redirect(url('/'))->with('message', 'Verify email successfully');
            }

            return failResponse('email not verified');
        }

        return request()?->wantsJson()
            ? successResponse(message: 'email verified')
            : redirect(url('/'))->with('message', 'email verified');

    }
}
