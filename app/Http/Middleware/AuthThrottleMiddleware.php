<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

class AuthThrottleMiddleware
{
    protected int $maxAttempts = 10;

    protected int $maxTimerSeconds = 60;

    public function handle(Request $request, Closure $next): Response
    {
        $key = $this->throttleKey($request);

        if (RateLimiter::tooManyAttempts($key, $this->maxAttempts)) {
            event(new Lockout($request));

            $seconds = RateLimiter::availableIn($key);

            throw ValidationException::withMessages([
                'throttle' => trans('auth.throttle', [
                    'seconds' => $seconds,
                    'minutes' => ceil($seconds / 60),
                ]),
            ]);
        }

        RateLimiter::hit($key, $this->maxTimerSeconds);

        //        RateLimiter::clear(request()->ip());

        return $next($request);
    }

    public function throttleKey(Request $request): string
    {
        return $request->ip();
    }
}
