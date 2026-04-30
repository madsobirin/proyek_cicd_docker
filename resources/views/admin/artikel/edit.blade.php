@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h3>Edit Artikel</h3>

    <form action="{{ route('admin.artikel.update', $artikel->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="mb-3">
            <label class="form-label">Kategori</label>
            <select name="kategori" class="form-control">
                <option value="">-- Pilih Kategori --</option>
                @foreach ($kategori as $k)
                    <option value="{{ $k->nama_kategori }}"
                        {{ $artikel->kategori === $k->nama_kategori ? 'selected' : '' }}>
                        {{ $k->nama_kategori }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Judul</label>
            <input type="text" name="judul" class="form-control" value="{{ old('judul', $artikel->judul) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Penulis</label>
            <input type="text" name="penulis" class="form-control" value="{{ old('penulis', $artikel->penulis) }}">
        </div>

        <div class="mb-3">
            <label>Isi</label>
            {{-- textarea sekarang menggunakan name="isi" dan id="isi" untuk TinyMCE --}}
            <textarea name="isi" id="isi" class="form-control @error('isi') is-invalid @enderror" rows="8"
                required>{{ old('isi', $artikel->isi) }}</textarea>
            @error('isi')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Gambar</label><br>
            @if ($artikel->gambar)
                <img src="{{ Storage::url($artikel->gambar) }}" width="180" class="mb-2 rounded">
            @endif
            <input type="file" name="gambar" class="form-control">
        </div>

        <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" value="1" id="is_featured" name="is_featured" {{ $artikel->is_featured ? 'checked' : '' }}>
            <label class="form-check-label" for="is_featured">
                Tandai sebagai artikel unggulan
            </label>
        </div>

        <button class="btn btn-success">Update</button>
        <a href="{{ route('admin.artikel.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>

{{-- TinyMCE: jika layout sudah memuat tinymce.js, hapus tag <script src=...> berikut agar tidak duplikat --}}
    <script src="https://cdn.jsdelivr.net/npm/tinymce@6.8.2/tinymce.min.js" referrerpolicy="origin"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof tinymce === 'undefined') {
                console.error('TinyMCE tidak ditemukan. Pastikan script tinymce telah dimuat.');
                return;
            }

            tinymce.init({
                selector: 'textarea#isi',
                height: 350,
                menubar: false,
                plugins: 'lists link image media table code preview paste',
                toolbar: 'undo redo | styleselect | bold italic underline | alignleft aligncenter alignright | bullist numlist outdent indent | link image media | removeformat | code preview',
                branding: false,
                relative_urls: false,
                remove_script_host: false,
                convert_urls: true,
                content_style: "body { font-family: 'Poppins', sans-serif; font-size:14px }"
            });
        });
    </script>
@endsection
