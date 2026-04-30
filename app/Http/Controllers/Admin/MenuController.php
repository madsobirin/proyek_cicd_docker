<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MenuController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;
        $status = $request->status; // Tambahkan filter status

        $menus = Menu::when($search, function ($query) use ($search) {
            $query->where('nama_menu', 'LIKE', "%{$search}%");
        })
            ->when($status, function ($query) use ($status) {
                $query->where('target_status', $status);
            })
            ->latest()
            ->get();

        return view('admin.menu.index', compact('menus', 'search', 'status'));
    }

    public function create()
    {
        return view('admin.menu.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_menu' => 'required|string|max:255',
            'target_status' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'kalori' => 'nullable|integer|min:0',
            'waktu_memasak' => 'nullable|integer|min:0',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:3048'
        ]);

        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('menu', 'public');
        }

        Menu::create($data);

        return redirect()->route('admin.menu.index')
            ->with('success', 'Menu berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $menu = Menu::findOrFail($id);
        return view('admin.menu.edit', compact('menu'));
    }

    public function update(Request $request, $id)
    {
        $menu = Menu::findOrFail($id);

        $data = $request->validate([
            'nama_menu' => 'required|string|max:255',
            'target_status' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'kalori' => 'nullable|integer|min:0',
            'waktu_memasak' => 'nullable|integer|min:0',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:3048',
        ]);

        if ($request->hasFile('gambar')) {
            if ($menu->gambar && Storage::disk('public')->exists($menu->gambar)) {
                Storage::disk('public')->delete($menu->gambar);
            }
            $data['gambar'] = $request->file('gambar')->store('menu', 'public');
        }

        $menu->update($data);

        return redirect()->route('admin.menu.index')
            ->with('success', 'Menu berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $menu = Menu::findOrFail($id);

        if ($menu->gambar && Storage::disk('public')->exists($menu->gambar)) {
            Storage::disk('public')->delete($menu->gambar);
        }

        $menu->delete();

        return redirect()->back()->with('success', 'Menu berhasil dihapus!');
    }
}
