<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\User;

class VerifySsoToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $token = $request->input('token');

        if (!$token) {
            return response()->json(['error' => 'Token is missing.'], 400);
        }

        // Validasi token dari cache
        $user_id = cache('sso_token_' . $token);

        if (!$user_id) {
            return response()->json(['error' => 'Invalid or expired token.'], 400);
        }

        // Temukan pengguna berdasarkan user_id
        $user = User::find($user_id);

        if (!$user) {
            return response()->json(['error' => 'User not found.'], 404);
        }

        // Tambahkan pengguna ke request untuk digunakan di controller
        $request->attributes->add(['sso_user' => $user]);

        // Hapus token dari cache setelah validasi untuk mencegah reuse
        cache()->forget('sso_token_' . $token);

        return $next($request);
    }
}