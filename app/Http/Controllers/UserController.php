<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // Tampilkan semua user
    public function index()
    {
        $user = User::all();
        return view('pages.user.index', compact('user'));
    }

    // Tambah user baru

    public function create()
    {
        return view('pages.user.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:100',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6',
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('pages.user.index')->with('success', 'User berhasil ditambahkan.');
    }

    // Form edit
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('pages.user.edit', compact('user'));
    }

    // Update data user
    public function update(Request $request, $id)
{
    $user = User::findOrFail($id);

    $request->validate([
        'name' => 'required|string|max:100',
        'email' => 'required|email|unique:users,email,' . $user->id,
        'password' => 'nullable|min:6',
    ]);

    $data = $request->only(['name', 'email']);
    if ($request->filled('password')) {
        $data['password'] = Hash::make($request->password);
    }

    $user->update($data);

    return redirect()->route('user.index')->with('success', 'User berhasil diperbarui.');
}

    // Hapus user
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('user.index')->with('success', 'User berhasil dihapus.');
    }
}
