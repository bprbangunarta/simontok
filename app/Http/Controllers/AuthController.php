<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Session;

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
            'username' => "Username yang anda masukkan salah",
            'password' => 'Password yang anda masukkan salah',
        ]);
    }

    function loginApi(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        $client = new Client();

        $headers = [
            'Accept' => 'application/json',
            'Content-Type' => 'application/x-www-form-urlencoded'
        ];

        $options = [
            'form_params' => [
                'username' => $request->username,
                'password' => $request->password
            ]
        ];

        try {
            $response = $client->post('https://simontok.test/api/login', [
                'headers' => $headers,
                'form_params' => $options['form_params']
            ]);

            $data = json_decode($response->getBody()->getContents(), true);
            // dd($data);

            if (isset($data['token'])) {
                $credentials = $request->only('username', 'password');
                if (auth()->attempt($credentials)) {
                    $request->session()->regenerate();

                    return redirect()->intended('dashboard');
                }
            } else {
                $errorMessage = isset($data['message']) ? $data['message'] : 'Terjadi kesalahan saat mencoba login.';
                return redirect()->back()->with('error', $errorMessage);
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Kredensial yang diberikan salah.');
        }
    }

    public function logout(Request $request)
    {
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
