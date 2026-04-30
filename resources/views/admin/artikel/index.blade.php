@extends('layouts.admin')

@section('content')
    <div class="container mt-4">
        <h3 class="fw-bold mb-3">Daftar Artikel</h3>

        <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
            <form class="d-flex" action="{{ route('admin.artikel.index') }}" method="GET">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Cari Artikel..."
                        value="{{ request('search') }}">
                    <button class="btn btn-outline-success" type="submit" aria-label="Cari">
                        <i class="bi bi-search"></i>
                    </button>
                </div>
            </form>

            <a href="{{ route('admin.artikel.create') }}" class="btn btn-success">
                <i class="bi bi-plus-lg me-1"></i> Tambah Artikel
            </a>
        </div>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="table-responsive">
            <table class="table table-bordered align-middle text-center">
                <thead class="table-light">
                    <tr>
                        <th width="60">No</th>
                        <th width="100">Foto</th>
                        <th>Judul</th>
                        <th>Kategori</th>
                        <th>Penulis</th>
                        <th>Dibaca</th>
                        <th width="180">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($data as $d)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <img src="{{ $d->gambar ? Storage::url($d->gambar) : 'https://via.placeholder.com/80x80' }}"
                                    alt="Foto {{ $d->judul }}" class="rounded" width="80" height="80"
                                    style="object-fit: cover;">
                            </td>
                            <td class="text-start">{{ $d->judul }}</td>
                            <td>
                                <span class="badge bg-success">
                                    {{ $d->kategori ?? '-' }}
                                </span>
                            </td>
                            <td>{{ $d->penulis ?? '-' }}</td>
                            <td>{{ $d->dibaca }}</td>
                            <td>
                                <a href="{{ route('admin.artikel.edit', $d->id) }}" class="btn btn-warning btn-sm">
                                    <i class="bi bi-pencil-square"></i> Edit
                                </a>

                                <form action="{{ route('admin.artikel.destroy', $d->id) }}" method="POST" class="d-inline"
                                    onsubmit="return confirm('Yakin ingin menghapus artikel ini?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-danger btn-sm">
                                        <i class="bi bi-trash"></i> Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted">
                                Tidak ada artikel ditemukan
                                @if (request('search'))
                                    untuk pencarian "<strong>{{ request('search') }}</strong>"
                                @endif
                            </td>
                        </tr>
                    @endforelse

                </tbody>
            </table>

            {{ $data->links() }}
        </div>

    </div>
@endsection
