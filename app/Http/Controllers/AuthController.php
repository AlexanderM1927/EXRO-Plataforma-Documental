<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Handle an authentication attempt.
     */
    public function authenticate(Request $request): JsonResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return response()->json(
                [
                    'message' => 'Login successfully',
                    'redirect' => route('dashboard')
                ],
                Response::HTTP_OK
            );
        } else {
            return response()->json(
                [
                    'message' => 'Bad credentials'
                ],
                Response::HTTP_FORBIDDEN
            );
        }
    }

    public function logout(Request $request): RedirectResponse
    {
        if (Auth::check()) {
            Auth::logout();
        }

        return response()->redirectTo(route('login'));

    }
}
