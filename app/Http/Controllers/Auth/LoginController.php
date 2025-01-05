<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    /**
     * Handle the authentication attempt.
     */
    public function authenticate(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'password' => 'required|string|max:100',
        ]);

        $ip = $request->ip();
        $username = $request->input('name');

        $throttleKey = 'login:' . $ip . '|' . $username;

        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            throw ValidationException::withMessages([
                'name' => "Превышен лимит попыток входа. Попробуйте снова через $seconds секунд(ы).",
            ]);
        }

        if (Auth::attempt(['name' => $username, 'password' => $validated['password']])) {
            $request->session()->regenerate();

            RateLimiter::clear($throttleKey);

            return redirect()->intended('/admin')->with('status', 'Вход выполнен!');
        }

        RateLimiter::hit($throttleKey, 30);

        return back()->withErrors([
            'name' => 'Неверное имя пользователя или пароль!',
        ])->onlyInput('name');
    }
    /**
     * Log the user out and invalidate the session.
     */
    public function signOut(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('status', 'Выход из аккаунта выполнен!');
    }
}
