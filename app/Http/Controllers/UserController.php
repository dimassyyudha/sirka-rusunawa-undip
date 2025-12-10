<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;

class UserController extends Controller
{
    public function index()
    {
        $dataUser = User::all();
        return view('pages.user.index', compact('dataUser'));
    }

    public function create()
    {
        return view('pages.user.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'  => 'required|max:100',
            'email' => ['required','email','unique:users,email'],
            'password' => 'required|min:8',
            'role' => 'required|in:admin,staff,kades',
            // Nama input di form adalah 'profile_photo'
            'profile_photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data['name']     = $request->name;
        $data['email']    = $request->email;
        $data['role']     = $request->role;
        $data['password'] = Hash::make($request->password);

        // LOGIKA UPLOAD
        if ($request->hasFile('profile_photo')) {
            $file = $request->file('profile_photo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = public_path('uploads/profile_pictures');

            if(!File::exists($path)) {
                File::makeDirectory($path, 0777, true, true);
            }

            $file->move($path, $filename);

            // SIMPAN NAMA FILE KE KOLOM 'profile_photo'
            $data['profile_photo'] = $filename;
        }

        User::create($data);

        return redirect()->route('user.index')->with('success', 'User Berhasil Ditambahkan!');
    }

    public function edit(string $id)
    {
        $dataUser = User::findOrFail($id);
        return view('pages.user.edit', compact('dataUser'));
    }

    public function update(Request $request, string $id)
    {
        $dataUser = User::findOrFail($id);

        $request->validate([
            'name' => 'required|max:100',
            'email' => ['required','email','unique:users,email,'.$id],
            'role' => 'required|in:admin,staff,kades',
            'profile_photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $dataUser->name = $request->name;
        $dataUser->email = $request->email;
        $dataUser->role = $request->role;

        if($request->password) {
            $dataUser->password = Hash::make($request->password);
        }

        // LOGIKA UPDATE FOTO
        if ($request->hasFile('profile_photo')) {
            $file = $request->file('profile_photo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = public_path('uploads/profile_pictures');

            if(!File::exists($path)) {
                File::makeDirectory($path, 0777, true, true);
            }

            // Hapus foto lama (Gunakan kolom profile_photo)
            if ($dataUser->profile_photo && File::exists($path . '/' . $dataUser->profile_photo)) {
                File::delete($path . '/' . $dataUser->profile_photo);
            }

            $file->move($path, $filename);

            // Update kolom di database
            $dataUser->profile_photo = $filename;
        }

        $dataUser->save();
        return redirect()->route('user.index')->with('success','Data Berhasil Diupdate!');
    }

    public function destroy(string $id)
    {
        $user = User::findOrFail($id);

        // Hapus file fisik
        if ($user->profile_photo && File::exists(public_path('uploads/profile_pictures/' . $user->profile_photo))) {
            File::delete(public_path('uploads/profile_pictures/' . $user->profile_photo));
        }

        $user->delete();
        return redirect()->route('user.index')->with('success','Data Berhasil Dihapus!');
    }
}
