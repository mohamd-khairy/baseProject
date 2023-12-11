<?php

namespace App\Http\Controllers\Auth;

use App\Events\OTPLogin;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\OtpRequest;
use App\Http\Resources\Auth\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum')->only('logout');
    }

    public function login(LoginRequest $request): JsonResponse
    {
        if (env('USE_OTP', false)) {
            return $this->loginWithOtp($request);
        } else {
            return $this->loginWithEmail($request);
        }
    }

    public function loginWithEmail(LoginRequest $request): JsonResponse
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            if (!$user->hasVerifiedEmail()) {
                return responseFail('Your email address is not verified.');
            }

            return responseSuccess([
                'token' => $user->createToken("API TOKEN")->plainTextToken,
                'user' => new UserResource($user),
            ], 'User Logged In Successfully');
        }

        return responseFail('Unauthorized', 401);
    }

    public function loginWithOtp(LoginRequest $request): JsonResponse
    {
        $userIdentifier = $request->input('email');

        // Get user to send  otp (e.g., via SMS or email)
        try {
            $user = User::where('email', $userIdentifier)->orWhere('phone', $userIdentifier)->first();
        } catch (\Throwable $th) {
            $user = User::where('email', $userIdentifier)->first();
        }

        if ($user) {

            // Generate a 4-digit OTP
            $otp = Str::random(4);

            // Store the OTP in the cache with a timeout (e.g., 5 minutes)
            Cache::put('otp:' . $userIdentifier, $otp, now()->addMinutes(5));

            $user->update(['otp' => $otp]);

            // Send the OTP to the user (e.g., via SMS or email)
            try {
                event(new OTPLogin($user, $otp));
            } catch (\Throwable $th) {
            }

            return responseSuccess('OTP sent successfully');
        }

        return responseFail('No User With this Data');
    }

    public function verifyOTP(OtpRequest $request): JsonResponse
    {
        $userIdentifier = $request->input('email');

        $enteredOTP = $request->input('otp');

        // Retrieve the stored OTP from the cache
        $storedOTP = Cache::get('otp:' . $userIdentifier);

        if ($storedOTP && $enteredOTP === $storedOTP) {

            $user = User::where('otp', $enteredOTP)->first();

            if ($user) {

                // Valid OTP, log the user in
                $user = auth()->loginUsingId($user->id);

                // Invalidate the OTP after successful login
                Cache::forget('otp:' . $userIdentifier);

                $user->update(['otp' => null]);

                return responseSuccess([
                    'token' => $user->createToken("API TOKEN")->plainTextToken,
                    'user' => new UserResource($user),
                ], 'User Logged In Successfully');
            }
        }

        return responseFail('Invalid OTP');
    }

    public function logout(Request $request): JsonResponse
    {
        $request->user()->tokens()->delete();

        return responseSuccess(msg: 'Logged out successfully');
    }
}
