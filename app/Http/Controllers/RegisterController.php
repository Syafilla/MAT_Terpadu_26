<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function index()
    {
        return view('auth.register');
    }

    public function check(Request $request)
    {
        $request->validate([
            'login' => 'required'
        ]);

        $user = User::where('nip', $request->login)
                    ->orWhere('username', $request->login)
                    ->first();

        if (!$user) {
            return response()->json([
                'status' => 'not_found'
            ]);
        }

        if ($user->status === 'aktif') {
            return response()->json([
                'status' => 'already_active'
            ]);
        }

        return response()->json([
            'status'   => 'found',
            'nip'      => $user->nip,
            'username' => $user->username,
            'id'       => $user->id
        ]);
    }

    public function activate(Request $request)
    {
        $request->validate([
            'user_id'  => 'required',
            'email'    => 'required|email|unique:users',
            'password' => 'required|min:6'
        ]);

        $user = User::findOrFail($request->user_id);

        $user->update([
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'status'   => 'aktif'
        ]);

        return redirect('/login')->with('success','Akun berhasil diaktifkan');
    }
}

