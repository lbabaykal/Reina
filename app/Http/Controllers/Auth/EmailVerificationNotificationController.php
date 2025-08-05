<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use Illuminate\Validation\ValidationException;

class EmailVerificationNotificationController extends Controller
{
    public function __invoke(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            throw ValidationException::withMessages([
                'email' => 'Ваша электронная почта уже подтверждена.',
            ]);
        }

        $request->user()->sendEmailVerificationNotification();

        throw ValidationException::withMessages([
            'email' => 'Инструкция для подтверждения отправлена на вашу электронную почту.',
        ]);
    }
}
