<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $users = Account::query()
            ->when($search, function ($q) use ($search) {
                $q->where('nama_lengkap', 'like', "%{$search}%")
                    ->orWhere('username', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            })
            ->orderBy('id', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required',
            'username'     => 'required|unique:accounts',
            'email'        => 'required|email|unique:accounts',
            'password'     => 'required|min:6',
            'role'         => 'required',
            'photo'        => 'nullable|image|max:2048',
        ]);

        $data = $request->except('photo', 'password');
        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('profile', 'public');
        }
        $data['password'] = Hash::make($request->password);

        Account::create($data);

        return redirect()->route('admin.users.index')->with('success', 'Pengguna berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $user = Account::findOrFail($id);

        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = Account::findOrFail($id);

        $request->validate([
            'nama_lengkap' => 'required',
            'username' => "required|unique:accounts,username,$id",
            'email' => "required|email|unique:accounts,email,$id",
            'role' => 'required',
            'photo' => 'nullable|image|max:2048',
        ]);

        $data = $request->except('photo');

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        } else {
            unset($data['password']);
        }

        if ($request->password) {
            $data['password'] = Hash::make($request->password);
        }

        if ($request->hasFile('photo')) {
            // hapus file lama (cek beberapa kemungkinan format path)
            if ($user->photo) {
                if (Storage::disk('public')->exists($user->photo)) {
                    Storage::disk('public')->delete($user->photo);
                } elseif (Storage::disk('public')->exists('profile/' . $user->photo)) {
                    Storage::disk('public')->delete('profile/' . $user->photo);
                }
            }

            // simpan path lengkap yang dikembalikan Storage
            $path = $request->file('photo')->store('profile', 'public'); 
            $data['photo'] = $path;
        }

        $user->update($data);

        return redirect()->route('admin.users.index')->with('success', 'Pengguna berhasil diperbarui.');
    }


    public function destroy($id)
    {
        $user = Account::findOrFail($id);

        if ($user->photo) {
            Storage::disk('public')->delete($user->photo);
        }

        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'Pengguna berhasil dihapus.');
    }
}
