<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function index()
    {
        if (auth()->check()) {
            return redirect('dashboard');
        }

        return view('auth.login');
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->only('username', 'password');

        if (auth()->attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->intended('dashboard');
        }

        return back()->withErrors([
            'username' => 'Username yang anda masukkan salah',
            'password' => 'Password yang anda masukkan salah',
        ]);
    }

    public function logout(Request $request)
    {
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
