<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('pages.auth.login');
    }

    public function showRegisterForm()
    {
        return view('pages.auth.register');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        // 3. Cek password menggunakan Hash::check
        if ($user && Hash::check($request->password, $user->password)) {

            // Loginkan user
            Auth::login($user);
            $request->session()->regenerate();

            // 4. Tampilkan halaman Dashboard
            return redirect()->route('dashboard')->with('success', 'Selamat Datang, ' . $user->name . '!');
        }

        // 5. Jika tidak sama, kembali ke login dengan error
        return back()->withErrors([
            'email' => 'Email atau Password yang Anda masukkan salah.',
        ])->onlyInput('email');
    }

    public function register(Request $request)
    {
        $request->validate([
            'nama' => 'required|max:100',
            'email' => ['required', 'email', 'unique:users,email'],
            'role' => 'required|in:admin,staff,kades',
            'password' => 'required|min:8|confirmed',
        ], [
            'nama.required' => 'Nama tidak boleh kosong',
            'email.required' => 'Email tidak boleh kosong',
            'email.email' => 'Email tidak valid',
            'email.unique' => 'Email sudah terdaftar',
            'password.required' => 'Password tidak boleh kosong',
            'password.min' => 'Password minimal 8 karakter',
            'password.confirmed' => 'Konfirmasi password tidak cocok',
        ]);

        $data['name']     = $request->nama;
        $data['email']    = $request->email;
        $data['password'] = Hash::make($request->password);
        $data['role']     = $request->role;

        User::create($data);

        return redirect()->route('auth.login')->with('success', 'Registrasi berhasil! Silakan Login');
    }

    /**
     * Display the specified resource.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('auth.login');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
