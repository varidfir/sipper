<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'login' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        $loginValue = trim($credentials['login']);

        // Email is normalized only for the authentication lookup.
        // The password is never flashed back to the browser.
        $isEmail = filter_var($loginValue, FILTER_VALIDATE_EMAIL) !== false;
        $field = $isEmail ? 'email' : 'username';
        $loginValue = $isEmail ? strtolower($loginValue) : $loginValue;

        if (!Auth::attempt([
            $field => $loginValue,
            'password' => $credentials['password'],
        ], false)) {
            // Keep only the safe identifier in the form after a failed login.
            // Never use old('password') or flash the password to the session.
            return back()
                ->withErrors(['login' => 'Username/email atau password salah.'])
                ->withInput(['login' => $loginValue]);
        }

        // Always regenerate the session after successful authentication.
        // Do not use "remember me" implicitly; it can create unnecessary
        // remember-token/session state for a simple internal application.
        $request->session()->regenerate();
        $request->session()->put('auth.password_confirmed_at', now()->timestamp);
        $request->session()->forget('url.intended');

        return redirect()->route('dashboard');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
