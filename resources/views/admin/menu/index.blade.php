@extends('layouts.admin')

@section('content')
    <div class="container-fluid">
        <h3 class="fw-bold mb-3 mt-3">Daftar Menu Sehat</h3>

        <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">

            <form class="d-flex" action="{{ route('admin.menu.index') }}" method="GET">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Cari Menu"
                        value="{{ request('search') }}">
                    <button class="btn btn-outline-success" type="submit" aria-label="Cari">
                        <i class="bi bi-search"></i>
                    </button>
                </div>
            </form>


            <a href="{{ route('admin.menu.create') }}" class="btn btn-success">
                <i class="bi bi-plus-lg me-1"></i> Tambah Menu
            </a>
        </div>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="table-responsive">
            <table class="table table-bordered align-middle text-center">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Foto</th>
                        <th>Menu</th>
                        <th>Target Status</th>
                        <th>Waktu Memasak</th>
                        <th>Deskripsi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($menus as $index => $item)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>
                                <img src="{{ $item->gambar ? Storage::url($item->gambar) : 'https://via.placeholder.com/80x80' }}"
                                    alt="Menu {{ $item->nama_menu }}" class="rounded" width="100" height="100">
                            </td>
                            <td class="text-start">{{ $item->nama_menu }}</td>
                            <td>
                                <span
                                    class="badge {{ $item->target_status == 'Normal' ? 'bg-success' : ($item->target_status == 'Kurus' ? 'bg-info' : 'bg-warning') }}">
                                    {{ $item->target_status ?? '-' }}
                                </span>
                            </td>
                            <td>{{ !is_null($item->kalori ?? null) ? $item->kalori . ' kkal' : '-' }}</td>
                            <td>{{ !is_null($item->waktu_memasak ?? null) ? $item->waktu_memasak . ' menit' : '-' }}</td>
                            <td class="text-start">{!! Str::limit($item->deskripsi, 80) !!}</td>
                            <td>
                                <a href="{{ route('admin.menu.edit', $item->id) }}" class="btn btn-sm btn-primary">
                                    <i class="bi bi-pencil-square me-1"></i> Edit
                                </a>
                                <form action="{{ route('admin.menu.destroy', $item->id) }}" method="POST"
                                    class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger"
                                        onclick="return confirm('Yakin ingin menghapus menu ini?')">
                                        <i class="bi bi-trash me-1"></i> Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-muted">
                                Tidak ada menu
                                ditemukan{{ request('search') ? ' untuk pencarian "' . request('search') . '"' : '' }}.
                            </td>
                        </tr>
                    @endforelse

                </tbody>
            </table>
        </div>
    </div>
@endsection
