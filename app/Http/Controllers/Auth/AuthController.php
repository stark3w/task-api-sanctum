<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\AuthRequest;
use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function register(AuthRequest $request)
    {
        $data = $request->validated();

        $user = User::create($data);

        $token = $user->createToken($data['token_name'])->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token,
        ]);
    }

    public function adminToken(Request $request)
    {
        $token = $request->user()->createToken('Admin Token',['task:manage'])->plainTextToken;

        return response()->json([
            'token' => $token,
        ]);
    }
}
