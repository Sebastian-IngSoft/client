<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\View\View;


class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email|string',
            'password' => 'required|string',
        ]);

        $response = Http::withHeaders([
            'Accept' => 'application/json'
        ])
            ->post('http://api.test/v1/login', [
                'email' => $request->email,
                'password' => $request->password
            ]);

        
        $user = User::updateOrCreate([
            'email' => $response->json()['data']['email']
        ],$response->json()['data']);
        return $user;
        // $request->authenticate();

        // $request->session()->regenerate();

        // return redirect()->intended(route('dashboard',false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
