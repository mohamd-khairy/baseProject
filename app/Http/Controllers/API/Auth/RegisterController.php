<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\Auth\UserResource;
use App\Models\User;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\JsonResponse;

class RegisterController extends Controller
{
    use SendsPasswordResetEmails;

    public function register(RegisterRequest $request): JsonResponse
    {
        /** create new user with verified data */
        $user = User::create($request->validated());

        if ($user) {

            return responseSuccess(new UserResource($user), 'User Created Successfully');
        }

        return responseFail('User Not created');
    }
}
