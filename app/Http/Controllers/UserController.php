<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filterableColumns = ['role'];

        $data['dataUser'] = User::filter($request, $filterableColumns)
            ->paginate(5)
            ->withQueryString();
        return view('pages.user.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.user.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //dd($request->all())
        $request->validate([
            'name'          => 'required|max:100',
            'email'         => ['required', 'email', 'unique:users,email'],
            'password'      => 'required|min:8',
            'role'          => 'required',
            // Validasi Foto (Opsional, Max 2MB)
            'profile_photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data['name']     = $request->name;
        $data['email']    = $request->email;
        $data['role']     = $request->role;
        $data['password'] = Hash::make($request->password);

        // --- LOGIKA UPLOAD FOTO ---
        if ($request->hasFile('profile_photo')) {
            $file     = $request->file('profile_photo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path     = public_path('uploads/profile_pictures'); // Folder tujuan

            // Buat folder jika belum ada
            if (! File::exists($path)) {
                File::makeDirectory($path, 0777, true, true);
            }

            $file->move($path, $filename);
            $data['profile_picture'] = $filename; // Simpan nama file ke database
        }

        User::create($data);

        return redirect()->route('user.index')->with('success', 'User berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data['dataUser'] = User::findOrFail($id);
        return view('pages.user.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $dataUser = User::findOrFail($id);

        $request->validate([
            'name'          => 'required|max:100',
            'email'         => ['required', 'email', 'unique:users,email,' . $id],
            'role'          => 'required',
            'profile_photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $dataUser->name  = $request->name;
        $dataUser->email = $request->email;
        $dataUser->role  = $request->role;

        if ($request->password) {
            $dataUser->password = Hash::make($request->password);
        }

        // --- LOGIKA UPDATE FOTO ---
        if ($request->hasFile('profile_photo')) {
            $file     = $request->file('profile_photo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path     = public_path('uploads/profile_pictures');

            if (! File::exists($path)) {
                File::makeDirectory($path, 0777, true, true);
            }

            // HAPUS FOTO LAMA (Jika ada dan bukan default)
            if ($dataUser->profile_picture && File::exists($path . '/' . $dataUser->profile_picture)) {
                File::delete($path . '/' . $dataUser->profile_picture);
            }

            $file->move($path, $filename);
            $dataUser->profile_picture = $filename;
        }

        $dataUser->save();
        return redirect()->route('user.index')->with('success', 'Data Berhasil Diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);

        $user->delete();
        return redirect()->route('user.index')->with('success', 'Data Berhasil Dihapus!');
    }
}
