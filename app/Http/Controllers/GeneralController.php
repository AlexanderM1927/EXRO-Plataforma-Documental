<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class GeneralController extends Controller
{
    /**
     * Show the login form.
     */
    public function login(Request $request): RedirectResponse|Response
    {
        if (Auth::check()) {
            return response()->redirectTo(route('dashboard'));
        }

        return Inertia::render('Login');
    }

    /**
     * Show the dashboard.
     */
    public function show(Request $request): Response
    {
        return Inertia::render('Dashboard', [
            'user' => Auth::user()
        ]);
    }
}
