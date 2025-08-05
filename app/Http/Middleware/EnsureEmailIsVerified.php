<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Lang;

class EnsureEmailIsVerified
{
    public function handle($request, Closure $next)
    {
        if (! $request->user() ||
            ($request->user() instanceof MustVerifyEmail && ! $request->user()->hasVerifiedEmail())
        ) {
            abort(403, Lang::get('auth.verified'));
        }

        return $next($request);
    }
}
