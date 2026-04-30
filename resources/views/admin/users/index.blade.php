@extends('layouts.admin')

@section('content')
    <div class="container-fluid">
        <h3 class="fw-bold mb-3 mt-3">Daftar Pengguna</h3>

        {{-- Search --}}
        <div class="d-flex justify-content-start mb-3 flex-wrap gap-2">
            <form class="d-flex" action="{{ route('admin.users.index') }}" method="GET">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Cari Nama / Email"
                        value="{{ request('search') }}">
                    <button class="btn btn-outline-success" type="submit" aria-label="Cari">
                        <i class="bi bi-search"></i>
                    </button>
                </div>
            </form>
        </div>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="table-responsive">
            <table class="table table-bordered align-middle text-center">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th class="text-start">Nama</th>
                        <th>Email</th>
                        {{-- <th>Peran</th> --}}
                        <th>Status</th>
                        <th style="width: 180px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $index => $user)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td class="text-start">{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            {{-- <td><span class="badge bg-info text-dark">{{ $user->role ?? 'User' }}</span></td> --}}
                            <td>
                                @if (isset($user->is_active))
                                    <span class="badge {{ $user->is_active ? 'bg-success' : 'bg-secondary' }}">
                                        {{ $user->is_active ? 'Aktif' : ($user->last_login_at ? 'Non-Aktif' : 'Belum Login') }}
                                    </span>
                                @else
                                    <span class="badge bg-secondary">Status tidak tersedia</span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex justify-content-center gap-2">
                                    <form action="{{ route('admin.users.toggleStatus', $user->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-primary"
                                            onclick="return confirm('Ubah status pengguna ini?')">
                                            Ubah Status
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger"
                                            onclick="return confirm('Yakin ingin menghapus pengguna ini?')">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-muted">Belum ada data pengguna</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
