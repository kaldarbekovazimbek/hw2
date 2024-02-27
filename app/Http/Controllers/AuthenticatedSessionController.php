<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        if (Auth::attempt($request->only('email', 'password'))) {
            $user = Auth::user();

            $token = $user->createToken('auth-token')->plainTextToken;

            return response()->json(['token' => $token, 'message' => 'Login successful']);
        }

        return response()->json(['message' => 'Invalid credentials'], 401);
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();

        return response()->json([
            "message" => "logged out"
        ]);
    }
}
