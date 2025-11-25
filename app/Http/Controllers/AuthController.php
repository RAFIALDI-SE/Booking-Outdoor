<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class AuthController extends Controller
{
    public function register() {

        return view('auth.register');
    }

    public function registerStore(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:6',
            'profile_picture' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $profilePath = 'default-profile.png'; // default jika tidak upload
        if ($request->hasFile('profile_picture')) {
            $profilePath = $request->file('profile_picture')->store('profiles', 'public');
        }

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'profile_picture' => $profilePath,
            'is_admin' => false, // user biasa default
        ]);

        return redirect()->route('login')->with('success', 'Registrasi berhasil! Silakan login.');
    }
}
