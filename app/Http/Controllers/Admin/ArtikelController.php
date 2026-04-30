<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Artikel;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ArtikelController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;

        $data = Artikel::when($search, function ($query) use ($search) {
            $query->where('judul', 'LIKE', "%{$search}%");
        })
            ->latest()
            ->paginate(10);

        return view('admin.artikel.index', compact('data', 'search'));
    }

    public function create()
    {
        $kategori =Kategori::all();
        // dd($kategori);
        return view('admin.artikel.create', compact('kategori'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kategori' => 'nullable|string|exists:kategori,nama_kategori',
            'judul'       => 'required|string|max:255',
            'penulis'     => 'nullable|string|max:255',
            'isi'         => 'required',
            'gambar'      => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // resolve nama kategori jika ada kategori_id
        $kategoriNama = null;
        if ($request->filled('kategori_id')) {
            $kat = kategori::find($request->kategori_id);
            $kategoriNama = $kat?->nama_kategori;
        }

        $slug = $this->generateUniqueSlug($request->judul);
        $gambarPath = null;
        if ($request->hasFile('gambar')) {
            $gambarPath = $request->file('gambar')->store('artikel', 'public');
        }

        artikel::create([
            'kategori'    => $request->kategori,
            'judul'       => $request->judul,
            'slug'        => $slug,
            'isi'         => $request->isi,
            'gambar'      => $gambarPath,
            'penulis'     => $request->penulis ?: 'Admin',
            'is_featured' => $request->boolean('is_featured', false),
            'dibaca'      => 0,
        ]);
        return redirect()->route('admin.artikel.index')->with('success', 'Artikel berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $artikel  = artikel::findOrFail($id);
        $kategori = kategori::all();
        return view('admin.artikel.edit', compact('artikel', 'kategori'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'kategori'    => 'nullable|string|exists:kategori,nama_kategori',
            'judul'       => 'required|string|max:255',
            'penulis'     => 'nullable|string|max:255',
            'isi'         => 'required',
            'gambar'      => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);
        $artikel = artikel::findOrFail($id);
        // $slug    = $this->generateUniqueSlug($request->judul, $artikel->id);
        $gambarPath = $artikel->gambar;
        if ($request->hasFile('gambar')) {
            if ($artikel->gambar && Storage::disk('public')->exists($artikel->gambar)) {
                Storage::disk('public')->delete($artikel->gambar);
            }
            $gambarPath = $request->file('gambar')->store('artikel', 'public');
        }

        $artikel->update([
            'kategori'    => $request->kategori,
            'judul'       => $request->judul,
            'slug'        => $this->generateUniqueSlug($request->judul, $artikel->id),
            'isi'         => $request->isi,
            'gambar'      => $gambarPath,
            'penulis'     => $request->penulis ?: 'Admin',
            'is_featured' => $request->boolean('is_featured', $artikel->is_featured),
        ]);
        return redirect()->route('admin.artikel.index')
            ->with('success', 'Artikel berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $artikel = artikel::findOrFail($id);
        if ($artikel->gambar && Storage::disk('public')->exists($artikel->gambar)) {
            Storage::disk('public')->delete($artikel->gambar);
        }
        $artikel->delete();
        return redirect()->route('admin.artikel.index')
            ->with('success', 'Artikel berhasil dihapus!');
    }

    private function generateUniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $baseSlug = Str::slug($title);
        $slug = $baseSlug ?: Str::random(8);
        $counter = 1;
        while (
            artikel::when($ignoreId, function ($query) use ($ignoreId) {
                $query->where('id', '!=', $ignoreId);
            })->where('slug', $slug)->exists()
        ) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }
        return $slug;
    }
}
