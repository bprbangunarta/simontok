<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Resources\AuthResource;
use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        if (auth()->attempt($request->only('username', 'password'))) {
            $user = User::where('username', $request->username)->first();
            $token = $user->createToken('auth-token')->plainTextToken;

            return new AuthResource([
                'user'  => $user,
                'token' => $token
            ]);
        } else {
            return response([
                'message' => 'Kredensial yang diberikan salah.'
            ], 401);
        }
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response([
            'message' => 'Berhasil logout.'
        ]);
    }
}
