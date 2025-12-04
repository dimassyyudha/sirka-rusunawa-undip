<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['dataUser'] = User::all();
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
		    'name'  => 'required|max:100',
		    'email' => ['required','email','unique:users,email'],
		    'password' => 'required|min:8',
		],[
            'nama.required'=>'Nama tidak boleh kosong',
            'password.required'=>'Password tidak boleh kosong',
            'email.required'=>'Email tidak boleh kosong',
            'email.email'=>'Email tidak valid'
        ]);

        $data['name']     = $request->name;
        $data['email']    = $request->email;
        $data['role']    = $request->role;
        $data['password'] = Hash::make($request->password);

        User::create($data);

        return redirect()->route('user.index')->with('success', 'Penambahan Data Berhasil!');
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
        $user_id = $id;
        $dataUser= User::findOrFail($user_id);

        $dataUser->name = $request->name;
        $dataUser->email = $request->email;
        $dataUser->role = $request->role;
        $dataUser->password = Hash::make($request->password);

        $dataUser->save();
        return redirect()->route('user.index')->with('success','Data Berhasil Diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);

        $user->delete();
        return redirect()->route('user.index')->with('success','Data Berhasil Dihapus!');
    }
}
