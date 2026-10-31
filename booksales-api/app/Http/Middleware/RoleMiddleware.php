<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Pakai di route: ->middleware('role:admin')
     * Bisa lebih dari satu role: ->middleware('role:admin,editor')
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = auth('api')->user();

        // Belum login / token tidak valid
        if (!$user) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Unauthenticated. Silakan login terlebih dahulu',
            ], 401);
        }

        // Sudah login, tetapi role tidak sesuai
        if (!in_array($user->role, $roles)) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Akses ditolak. Endpoint ini hanya untuk role: ' . implode(', ', $roles),
            ], 403);
        }

        return $next($request);
    }
}
