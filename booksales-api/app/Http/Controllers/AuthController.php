<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthController
{
    // Register (POST /api/register) - role otomatis "customer"
    public function register(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:8',
        ]);

        $user = User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => $validated['password'], // otomatis di-hash oleh cast "hashed" di model
            'role'     => 'customer',
        ]);

        return response()->json([
            'status'  => 'success',
            'message' => 'Berhasil melakukan registrasi',
            'data'    => $user,
        ], 201);
    }

    // Login (POST /api/login)
    public function login(Request $request): JsonResponse
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        $token = auth('api')->attempt($credentials);

        if (!$token) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Email atau password salah',
            ], 401);
        }

        $user = auth('api')->user();
        $user->update(['last_access' => now()]);

        return response()->json([
            'status'  => 'success',
            'message' => 'Berhasil login',
            'data'    => [
                'user'         => $user,
                'access_token' => $token,
                'token_type'   => 'bearer',
                'expires_in'   => auth('api')->factory()->getTTL() * 60,
            ],
        ], 200);
    }

    // Data user yang sedang login (GET /api/me)
    public function me(): JsonResponse
    {
        return response()->json([
            'status'  => 'success',
            'message' => 'Berhasil mengambil data user yang sedang login',
            'data'    => auth('api')->user(),
        ], 200);
    }

    // Logout (POST /api/logout)
    public function logout(): JsonResponse
    {
        auth('api')->logout();

        return response()->json([
            'status'  => 'success',
            'message' => 'Berhasil logout',
        ], 200);
    }
}