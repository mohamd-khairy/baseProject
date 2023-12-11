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
                /** event for send verify email to user */
                event(new Registered($user));
            } catch (Throwable $th) {
                //throw $th;
            }

            return responseSuccess(msg: 'Verify email send successfully');
        }

        return responseFail('email verified');
    }

    /**
     * @param User $user
     * @param $hash
     * @return JsonResponse|RedirectResponse|Redirector
     */
    public function verify(User $user, $hash): JsonResponse|RedirectResponse|Redirector
    {
        if (!$user->email_verified_at) {

            if ($user->update(['email_verified_at' => now()])) {
                return request()->wantsJson()
                    ? responseSuccess(msg: 'Verify email successfully')
                    : redirect(url('/'))->with('message', 'Verify email successfully');
            }

            return responseFail('email not verified');
        }

        return request()->wantsJson()
            ? responseSuccess(msg: 'email verified')
            : redirect(url('/'))->with('message', 'email verified');

    }
}
