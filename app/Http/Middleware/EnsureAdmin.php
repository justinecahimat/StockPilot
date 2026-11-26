<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureAdmin
{
    public function handle(
        Request $request,
        Closure $next
    ): Response {
        $user = $request->user();

        if (!$user || strtolower($user->role) !== 'admin') {
            abort(403, 'You are not authorized to access this page.');
        }

        if ($user->status !== 'approved') {
            abort(403, 'Your account is not approved.');
        }

        return $next($request);
    }
}