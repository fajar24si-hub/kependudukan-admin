<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    // Tampilkan semua user dengan pagination, search, dan filter
    public function index(Request $request)
    {
        $query = User::query();

        // Search functionality
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('role', 'like', "%{$search}%");
            });
        }

        // Filter by date range
        if ($request->has('start_date') && !empty($request->start_date)) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }

        if ($request->has('end_date') && !empty($request->end_date)) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        // Filter by role jika ada
        if ($request->has('role') && !empty($request->role)) {
            $query->where('role', $request->role);
        }

        // Sort functionality - TAMBAHKAN SORT UNTUK ROLE
        $sort = $request->get('sort', 'created_at');
        $direction = $request->get('direction', 'desc');
        $query->orderBy($sort, $direction);

        // Pagination dengan 10 data per halaman
        $users = $query->paginate(10)->withQueryString();

        // Tambahkan daftar role untuk filter
        $roles = ['Super Admin', 'Administrator', 'Pelanggan', 'Mitra'];

        return view('pages.user.index', compact('users', 'roles'));
    }

    // Tambah user baru
    public function create()
    {
        $roles = ['Super Admin', 'Administrator', 'Pelanggan', 'Mitra'];
        return view('pages.user.create', compact('roles'));
    }

    public function store(Request $request)
    {
        Log::info('Store user request received', ['data' => $request->except('password')]);

        $request->validate([
            'name'     => 'required|string|max:100',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'role'     => 'required|in:Super Admin,Administrator,Pelanggan,Mitra',
            'foto_profil' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $userData = [
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => $request->role,
        ];

        // Handle foto profil upload
        if ($request->hasFile('foto_profil')) {
            Log::info('Processing foto profil upload');

            $fotoProfil = $request->file('foto_profil');
            $filename = time() . '_' . $fotoProfil->getClientOriginalName();

            Log::info('File details', [
                'original_name' => $fotoProfil->getClientOriginalName(),
                'extension' => $fotoProfil->getClientOriginalExtension(),
                'size' => $fotoProfil->getSize(),
                'mime_type' => $fotoProfil->getMimeType()
            ]);

            // Store file 
            $path = $fotoProfil->storeAs('foto-profil', $filename, 'public'); // Simpan di storage/app/public
            Log::info('File stored at: ' . $path);

            // Verify file exists
            $fileExists = Storage::disk('public')->exists('foto-profil/' . $filename);
            Log::info('File exists after storage: ' . ($fileExists ? 'YES' : 'NO'));

            // Simpan path RELATIF untuk storage public
            $userData['foto_profil'] = 'foto-profil/' . $filename;
        } else {
            Log::info('No foto profil uploaded, will use default');
        }

        $user = User::create($userData);
        Log::info('User created successfully', [
            'user_id' => $user->id,
            'role' => $user->role,
            'foto_profil' => $user->foto_profil
        ]);

        return redirect()->route('user.index')->with('success', 'User berhasil ditambahkan.');
    }

    // Form edit
    public function edit($id)
    {
        $user = User::findOrFail($id);
        $roles = ['Super Admin', 'Administrator', 'Pelanggan', 'Mitra'];
        return view('pages.user.edit', compact('user', 'roles'));
    }

    // Update data user
    public function update(Request $request, $id)
    {
        Log::info('Update user request received', [
            'user_id' => $id,
            'data' => $request->except(['password', 'password_confirmation'])
        ]);

        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:6|confirmed',
            'role' => 'required|in:Super Admin,Administrator,Pelanggan,Mitra',
            'foto_profil' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
        ];

        // Update password jika diisi
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
            Log::info('Password updated for user: ' . $user->id);
        }

        // Handle foto profil upload
        if ($request->hasFile('foto_profil')) {
            Log::info('Processing foto profil update');

            $fotoProfil = $request->file('foto_profil');
            $filename = time() . '_' . $fotoProfil->getClientOriginalName();

            Log::info('New file details', [
                'original_name' => $fotoProfil->getClientOriginalName(),
                'extension' => $fotoProfil->getClientOriginalExtension(),
                'size' => $fotoProfil->getSize()
            ]);

            // Hapus foto lama jika ada
            if ($user->foto_profil) {
                $oldFileExists = Storage::disk('public')->exists($user->foto_profil);
                Log::info('Old file exists: ' . ($oldFileExists ? 'YES' : 'NO'));

                if ($oldFileExists) {
                    Storage::disk('public')->delete($user->foto_profil);
                    Log::info('Old file deleted: ' . $user->foto_profil);
                }
            }

            // Store file baru -
            $path = $fotoProfil->storeAs('foto-profil', $filename, 'public');
            Log::info('New file stored at: ' . $path);

            // Verify file exists
            $fileExists = Storage::disk('public')->exists('foto-profil/' . $filename);
            Log::info('New file exists after storage: ' . ($fileExists ? 'YES' : 'NO'));

            // Simpan path lengkap
            $data['foto_profil'] = 'foto-profil/' . $filename;
        } else {
            Log::info('No new foto profil uploaded');

            // Jika user memilih untuk menghapus foto
            if ($request->has('remove_photo') && $user->foto_profil) {
                Log::info('Removing existing photo per user request');
                $oldFileExists = Storage::disk('public')->exists($user->foto_profil);
                if ($oldFileExists) {
                    Storage::disk('public')->delete($user->foto_profil);
                }
                $data['foto_profil'] = null;
            }
        }

        $user->update($data);
        Log::info('User updated successfully', [
            'user_id' => $user->id,
            'role' => $user->role,
            'foto_profil' => $user->foto_profil
        ]);

        return redirect()->route('user.index')->with('success', 'User berhasil diperbarui.');
    }

    // Hapus user
    public function destroy($id)
    {
        Log::info('Delete user request received', ['user_id' => $id]);

        $user = User::findOrFail($id);

        // Hapus foto profil jika ada
        if ($user->foto_profil) {
            $fileExists = Storage::disk('public')->exists($user->foto_profil);
            Log::info('Foto profil exists for deletion: ' . ($fileExists ? 'YES' : 'NO'));

            if ($fileExists) {
                Storage::disk('public')->delete($user->foto_profil);
                Log::info('Foto profil deleted: ' . $user->foto_profil);
            }
        }

        $user->delete();
        Log::info('User deleted successfully', ['user_id' => $id]);

        return redirect()->route('user.index')->with('success', 'User berhasil dihapus.');
    }

    // Show user details
    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('pages.user.show', compact('user'));
    }
}
