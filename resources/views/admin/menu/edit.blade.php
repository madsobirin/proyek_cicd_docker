@extends('layouts.admin')

@section('content')
    <h3 class="fw-bold mb-3">Edit Menu</h3>

    <form action="{{ route('admin.menu.update', $menu->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Nama Menu</label>
            <input type="text" name="nama_menu" value="{{ old('nama_menu', $menu->nama_menu) }}"
                class="form-control @error('nama_menu') is-invalid @enderror" required>
            @error('nama_menu')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Letakkan di bawah input Nama Menu pada file Edit --}}
        <div class="mb-3">
            <label class="fw-bold text-primary">Target Status Rekomendasi</label>
            <select name="target_status" class="form-select @error('target_status') is-invalid @enderror">
                <option value="" disabled>-- Pilih Kategori BMI --</option>
                <option value="Kurus" {{ $menu->target_status == 'Kurus' ? 'selected' : '' }}>Kurus</option>
                <option value="Normal" {{ $menu->target_status == 'Normal' ? 'selected' : '' }}>Normal</option>
                <option value="Berlebih" {{ $menu->target_status == 'Berlebih' ? 'selected' : '' }}>Berlebih</option>
                <option value="Obesitas" {{ $menu->target_status == 'Obesitas' ? 'selected' : '' }}>Obesitas</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Deskripsi</label>
            {{-- textarea sekarang menggunakan name="deskripsi" dan id="deskripsi" untuk TinyMCE --}}
            <textarea name="deskripsi" id="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror" rows="8"
                required>{{ old('deskripsi', $menu->deskripsi) }}</textarea>
            @error('deskripsi')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label>Kalori (kkal)</label>
            <input type="number" name="kalori" value="{{ old('kalori', $menu->kalori) }}"
                class="form-control @error('kalori') is-invalid @enderror" min="0" placeholder="Contoh: 250">
            @error('kalori')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label>Waktu Memasak (menit)</label>
            <input type="number" name="waktu_memasak" value="{{ old('waktu_memasak', $menu->waktu_memasak) }}"
                class="form-control @error('waktu_memasak') is-invalid @enderror" min="0" placeholder="Contoh: 30">
            @error('waktu_memasak')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label>Foto Menu</label><br>
            @if ($menu->gambar)
                <img src="{{ Storage::url($menu->gambar) }}" alt="Foto {{ $menu->nama_menu }}" class="rounded mb-2"
                    width="160">
            @endif
            <input type="file" name="gambar" class="form-control @error('gambar') is-invalid @enderror">
            @error('gambar')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('admin.menu.index') }}" class="btn btn-secondary">Kembali</a>
    </form>

    {{-- TinyMCE: jika layout sudah memuat tinymce.js, hapus tag <script src=...> berikut agar tidak duplikat --}}
    <script src="https://cdn.jsdelivr.net/npm/tinymce@6.8.2/tinymce.min.js" referrerpolicy="origin"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof tinymce === 'undefined') {
                console.error('TinyMCE tidak ditemukan. Pastikan script tinymce telah dimuat.');
                return;
            }

            tinymce.init({
                selector: 'textarea#deskripsi',
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
