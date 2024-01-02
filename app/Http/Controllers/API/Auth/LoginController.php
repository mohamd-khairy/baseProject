<?php

namespace App\Http\Controllers\API\Auth;

use App\Events\OTPLogin;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\OtpRequest;
use App\Http\Resources\User\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum')->only('logout');
    }

    /**
     * @param LoginRequest $request
     * @return JsonResponse
     * @throws \Exception
     */
    public function login(LoginRequest $request): JsonResponse
    {
        if (config('app.use_otp', false)) {
            return $this->loginWithOtp($request);
        }

        return $this->loginWithEmail($request);
    }

    /**
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function loginWithEmail(LoginRequest $request): JsonResponse
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            if (!$user?->hasVerifiedEmail()) {
                return successResponse(['verify' => false], 'Your email address is not verified.', 400);
            }

            return successResponse([
                'token' => $user?->createToken("API TOKEN")->plainTextToken,
                'user' => new UserResource($user),
            ], 'User Logged In Successfully');
        }

        return failResponse('Unauthorized', 401);
    }

    /**
     * @param LoginRequest $request
     * @return JsonResponse
     * @throws \Exception
     */
    public function loginWithOtp(LoginRequest $request): JsonResponse
    {
        $userIdentifier = $request->input('email');

        try {

            $user = User::where('email', $userIdentifier)
                ->orWhere('phone', $userIdentifier)->first();
        } catch (\Throwable $th) {
            $user = User::where('email', $userIdentifier)->first();
        }

        if ($user) {
            $otp = random_int(1000, 9999);

            // Store the OTP in the cache with a timeout (e.g., 5 minutes)
            Cache::put('otp:' . $userIdentifier, $otp, now()->addMinutes(5));

            $user->update(['otp' => $otp]);

            try {
                event(new OTPLogin($user, $otp));
            } catch (\Throwable $th) {
            }

            return successResponse(['otp' => true], 'OTP sent successfully');
        }

        return failResponse('No User With this Data');
    }

    /**
     * @param OtpRequest $request
     * @return JsonResponse
     */
    public function verifyOTP(OtpRequest $request): JsonResponse
    {
        $userIdentifier = $request->input('email');
        $enteredOTP = $request->input('otp');

        // Retrieve the stored OTP from the cache
        $storedOTP = Cache::get('otp:' . $userIdentifier);

        if ($storedOTP && $enteredOTP == $storedOTP) {

            $user = User::where('otp', $enteredOTP)->first();

            if ($user) {

                // Valid OTP, log the user in
                $user = auth()->loginUsingId($user->id);

                Cache::forget('otp:' . $userIdentifier);

                $user->update(['otp' => null]);

                return successResponse([
                    'token' => $user->createToken("API TOKEN")->plainTextToken,
                    'user' => new UserResource($user),
                ], 'User Logged In Successfully');
            }
        }

        return failResponse('Invalid OTP');
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function logout(Request $request): JsonResponse
    {
        $request->user()->tokens()->delete();

        return successResponse(message: 'Logged out successfully');
    }
}
