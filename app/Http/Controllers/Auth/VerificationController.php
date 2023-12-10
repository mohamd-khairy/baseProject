<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\SendVerificationRequest;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;

class VerificationController extends Controller
{

    public function resend(SendVerificationRequest $request)
    {
        $user = User::where('email', $request->email)->first();

        if (!$user->hasVerifiedEmail()) {

            try {
                /** event for send verify email to user */
                event(new Registered($user));
            } catch (\Throwable $th) {
                //throw $th;
            }

            return responseSuccess(msg: 'Verify email send successfully');
        }

        return responseFail('email verified');
    }

    public function verify($id, $hash)
    {
        $user = User::find($id);

        if (!$user) {
            return responseFail('no user with this id');
        }

        if ($user->update(['email_verified_at' => now()])) {
            return responseSuccess(msg: 'Verify email successfully');
        }

        return responseFail('email not verified');
    }
}
