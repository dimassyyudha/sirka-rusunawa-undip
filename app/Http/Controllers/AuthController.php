<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // public function showLoginForm(Request $request)
    // {
    //     dd(session()->all());
    //     if ($request->filled('redirect')) {
    //         session(['url.intended' => $request->redirect]);
    //     }

    //     return view('pages.auth.login');
    // }
    public function showLoginForm(Request $request)
    {
        // session()->flash('success', 'TES BERHASIL');
        if ($request->filled('redirect')) {
            session(['url.intended' => $request->redirect]);
        }

        return view('pages.auth.login');
    }

    public function showRegisterForm()
    {
        return view('pages.auth.register');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ], [
            'email.required' => 'Email tidak boleh kosong.',
            'email.email' => 'Format email tidak valid.',
            'password.required' => 'Password tidak boleh kosong.',
        ]);

        $user = User::where('email', $credentials['email'])->first();

        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            return back()
                ->with('error', 'Email atau password salah.')
                ->withInput();
        }

        Auth::login($user, $request->boolean('remember'));
        $request->session()->regenerate();

        if ($user->role === 'admin') {
            session()->forget('url.intended');

            return redirect()
                ->route('admin.dashboard')
                ->with('success', 'Selamat datang, ' . $user->name . '!');
        }

        return redirect()
            ->intended(route('page.beranda'))
            ->with('success', 'Selamat datang, ' . $user->name . '!');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'gender' => ['required', 'in:laki-laki,perempuan'],
            'number_phone' => ['required', 'string', 'max:20'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'nama.required' => 'Nama tidak boleh kosong.',
            'email.required' => 'Email tidak boleh kosong.',
            'email.email' => 'Email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'gender.required' => 'Jenis kelamin wajib dipilih.',
            'gender.in' => 'Jenis kelamin tidak valid.',
            'number_phone.required' => 'Nomor HP tidak boleh kosong.',
            'password.required' => 'Password tidak boleh kosong.',
            'password.min' => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        User::create([
            'name' => $validated['nama'],
            'email' => $validated['email'],
            'gender' => $validated['gender'],
            'number_phone' => $validated['number_phone'],
            'password' => Hash::make($validated['password']),
            'role' => 'mahasiswa',
        ]);

        return redirect()
            ->route('login')
            ->with('success', 'Registrasi berhasil! Silakan login.');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()
            ->route('page.beranda')
            ->with('success', 'Berhasil logout.');
    }
}
