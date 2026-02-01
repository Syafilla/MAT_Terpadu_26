<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'login' => 'required',
            'password' => 'required'
        ]);

        $login = $request->login;

        $credentials = is_numeric($login)
            ? ['nip' => $login, 'password' => $request->password]
            : ['username' => $login, 'password' => $request->password];

        if (!Auth::attempt($credentials)) {
            return back()->withErrors([
                'login' => 'Username / NIP atau password salah'
            ]);
        }

        $request->session()->regenerate();

        $user = Auth::user();

        if ($user->status !== 'aktif') {
            Auth::logout();
            return back()->withErrors([
                'Akun belum diaktifkan'
            ]);
        }

        return match ($user->role) {
            'admin' => redirect('/admin/dashboard'),
            'user'  => redirect('/user/dashboard'),
            default => redirect('/login'),
        };

    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login')->with('success', 'Berhasil logout');
    }
    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required'],
            'new_password'     => ['required', 'min:6', 'confirmed'],
        ]);

        $user = auth()->user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->with('error', 'Password lama tidak sesuai');
        }

        if (Hash::check($request->new_password, $user->password)) {
            return back()->with('error', 'Password baru tidak boleh sama dengan password lama');
        }

        $user->update([
            'password' => Hash::make($request->new_password),
        ]);

        Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect('/login')
        ->with('success', 'Password berhasil diubah, silakan login ulang');
    }
}

