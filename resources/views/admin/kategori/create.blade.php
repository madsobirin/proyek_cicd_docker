@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h2>Tambah Kategori Baru</h2>

    <form action="{{ route('admin.kategori.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label class="form-label">Nama Kategori</label>
            <input type="text" name="nama_kategori" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('admin.kategori.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
