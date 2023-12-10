<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Resources\Auth\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum')->only('logout');
    }

    public function login(LoginRequest $request)
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

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return responseSuccess(msg: 'Logged out successfully');
    }
}
