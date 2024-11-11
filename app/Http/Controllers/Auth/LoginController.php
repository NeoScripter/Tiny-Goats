<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
    // Validate the request
    $validated = $request->validate([
        'name' => 'required|string|max:100',
        'password' => 'required|string|max:100',
    ]);

    // Prepare credentials for authentication
    $credentials = [
        'name' => $validated['name'],
        'password' => $validated['password'],
    ];

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();
        return redirect()->intended('/admin')->with('status', 'Вход выполнен!');
    }

    // Authentication failed
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

        return redirect('/login')->with('status', 'Вход выполнен!');
    }
}
