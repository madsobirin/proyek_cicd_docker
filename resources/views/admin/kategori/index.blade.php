@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h2 class="mb-3">Daftar Kategori</h2>

    <a href="{{ route('admin.kategori.create') }}" class="btn btn-success mb-3">
        + Tambah Kategori
    </a>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table table-bordered table-striped">
        <thead class="table-light">
            <tr>
                <th>No</th>
                <th>Nama Kategori</th>
                <th>Aksi</th>
            </tr>
        </thead>

        <tbody>
            @forelse($kategori as $k)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $k->nama_kategori }}</td>
                    <td>
                        <a href="{{ route('admin.kategori.edit', $k->id_kategori) }}"
                        class="btn btn-warning btn-sm">
                            Edit
                        </a>
                        <form action="{{ route('admin.kategori.destroy', $k->id_kategori) }}"
                            method="POST"
                            style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="btn btn-danger btn-sm"
                                    onclick="return confirm('Yakin ingin menghapus kategori ini?')">
                                Hapus
                            </button>
                        </form>

                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="text-center">
                        Belum ada data kategori.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
