@extends('layouts.admin')
@section('content')
<div class="container mt-4">
    <h2 class="mb-3">Update Kategori</h2>
    <form method="POST" action="{{ route('admin.kategori.update', $kategori->id_kategori) }}">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label class="form-label">ID Kategori</label>
            <input type="text" class="form-control" value="{{ $kategori->id_kategori }}" disabled>
        </div>
        <div class="mb-3">
            <label class="form-label">Nama Kategori</label>
            <input type="text" name="nama_kategori" class="form-control"
                   value="{{ $kategori->nama_kategori }}" required>
        </div>
        <a href="{{ route('admin.kategori.index') }}" class="btn btn-secondary">Kembali</a>
        <button type="submit" class="btn btn-success">Simpan Perubahan</button>
    </form>
</div>
@endsection
