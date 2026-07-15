<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::check()) {
            return redirect()->route('admin.dashboard');
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
            'role' => ['required', 'in:operasional,keuangan'],
        ]);

        $remember = $request->boolean('remember');

        $attempt = Auth::attempt([
            'username' => $credentials['username'],
            'password' => $credentials['password'],
            'role' => $credentials['role'],
            'status' => 'aktif',
        ], $remember);

        if (! $attempt) {
            throw ValidationException::withMessages([
                'username' => 'Kredensial tidak cocok atau peran tidak sesuai.',
            ]);
        }

        $request->session()->regenerate();

        return redirect()->intended(route('admin.dashboard'));
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('admin.login');
    }
}
