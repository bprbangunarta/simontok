<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfilePasswordRequest;
use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function profile()
    {
        return view('profile.show');
    }

    public function changeProfile(ProfileUpdateRequest $request)
    {
        $request->user()->update($request->all());

        if ($request->user()->wasChanged()) {
            return redirect()->route('profile')->with('success', 'Profil berhasil diubah');
        } else {
            return redirect()->route('profile')->with('success', 'Tidak ada perubahan pada profil');
        }
    }

    public function password()
    {
        return view('profile.password');
    }

    public function changePassword(ProfilePasswordRequest $request)
    {
        $user = $request->user();

        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->back()->withErrors(['current_password' => 'Kata sandi saat ini tidak cocok']);
        }

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->back()->with('success', 'Kata sandi berhasil diubah');
    }
}
