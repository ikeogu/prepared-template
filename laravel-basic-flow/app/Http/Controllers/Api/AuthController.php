<?php

namespace App\Http\Controllers\Api;

use App\Events\WelcomeEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    //

    public function register(RegisterRequest $request) : JsonResponse
    {
        /** @var User $user */
        $user = User::create($request->validated());
        $token = $user->createToken("$user->name token")->accessToken;

        event(new WelcomeEvent($user));

        return response()->json([
            'message' => "User created successfully",
              'data' => [
                'user' => $user,
                'token' => $token
             ],
             'status' => 201
        ]);
    }

    public function login(LoginRequest $request) : JsonResponse
    {
        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'password' => ['Password mismatched'],
            ]);
        }

        $token = $user->createToken("$user->name token")->accessToken;

         return response()->json([
            'message' => "User Login successfully",
             'data' => [
                'user' => $user,
                'token' => $token
             ],
             'status' => 201
        ]);

    }
}