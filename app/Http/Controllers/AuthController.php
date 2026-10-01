<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // ==================================================================
    // ================= LOGIN ADMIN ====================================
    // ==================================================================
    public function showLoginAdmin() {
        return view('auth.login-admin');
    }

    public function loginAdmin(Request $request) {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            $user = auth()->user();

            // Tolak jika bukan admin
            if ($user->role !== 'admin') {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                return back()->withErrors(['email' => 'Akun ini bukan Admin. Silakan login di halaman Dosen.']);
            }

            $request->session()->regenerate();
            return redirect()->route('dashboard')->with('success', 'Selamat datang Admin, ' . $user->name);
        }

        return back()->withErrors(['email' => 'Email atau password salah.'])->onlyInput('email');
    }

    // ==================================================================
    // ================= LOGIN & REGISTER DOSEN =========================
    // ==================================================================
    public function showLogin() {
        return view('auth.login');
    }

    public function login(Request $request) {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            $user = auth()->user();

            // Tolak jika bukan dosen (misalnya admin mencoba login di sini)
            if ($user->role !== 'dosen') {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                return back()->withErrors(['email' => 'Akun ini bukan Dosen. Silakan login di halaman Admin.']);
            }

            $request->session()->regenerate();
            return redirect()->route('dosen.modul3')->with('success', 'Selamat datang, ' . $user->name);
        }

        return back()->withErrors(['email' => 'Email atau password salah.'])->onlyInput('email');
    }

    public function showRegister() {
        return view('auth.register');
    }

    public function register(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'dosen',
        ]);

        Auth::login($user);
        return redirect()->route('dosen.modul3')->with('success', 'Akun Dosen berhasil dibuat!');
    }

    // ==================================================================
    // ================= LOGOUT =========================================
    // ==================================================================
    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}