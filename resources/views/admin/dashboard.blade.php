@extends('layouts.admin')

@section('content')
    <div class="container-fluid">
        <h3 class="fw-bold mb-3 mt-3">Dashboard Admin</h3>

        <div class="row g-4 mb-4">
            <div class="col-md-3">
                <div class="card p-3 border-0 shadow-sm">
                    <h6 class="text-muted mb-1">Total Pengguna</h6>
                    <h3 class="text-success">{{ $userCount }}</h3>
                </div>
            </div>

            @if (\Illuminate\Support\Facades\Schema::hasColumn('accounts', 'is_active'))
                <div class="col-md-3">
                    <div class="card p-3 border-0 shadow-sm">
                        <h6 class="text-muted mb-1">Pengguna Aktif</h6>
                        <h3 class="text-success">{{ $activeUserCount ?? 0 }}</h3>
                    </div>
                </div>
            @endif

            <div class="col-md-3">
                <div class="card p-3 border-0 shadow-sm">
                    <h6 class="text-muted mb-1">Total Menu</h6>
                    <h3 class="text-success">{{ $menuCount }}</h3>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card p-3 border-0 shadow-sm">
                    <h6 class="text-muted mb-1">Total Artikel</h6>
                    <h3 class="text-success">{{ $artikelCount }}</h3>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <!-- Left: Menu Terbaru -->
            <div class="col-lg-7 mb-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <h5 class="fw-bold">Menu Terbaru</h5>
                        <div class="table-responsive mt-3">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th style="width:60px">No</th>
                                        <th>Nama Menu</th>
                                        <th>Dilihat</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($menus as $index => $menu)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td class="text-start">{{ $menu->nama_menu }}</td>
                                            <td>{{ $menu->dibaca ?? 0 }}x</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center text-muted">Belum ada data</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right: Pengguna Terbaru -->
            <div class="col-lg-5 mb-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <h5 class="fw-bold">Pengguna Terbaru</h5>
                        <div class="table-responsive mt-3">
                            <table class="table table-sm table-bordered align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th style="width:40px">No</th>
                                        <th>Nama</th>
                                        <th>Email</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($latestUsers as $i => $u)
                                        <tr>
                                            <td>{{ $i + 1 }}</td>
                                            <td class="text-start">{{ $u->name }}</td>
                                            <td>{{ $u->email }}</td>
                                            <td>
                                                <div class="d-flex flex-column align-items-center">
                                                    @if (isset($u->is_active))
                                                        <span
                                                            class="badge {{ $u->is_active ? 'bg-success' : 'bg-secondary' }}">
                                                            {{ $u->is_active ? 'Aktif' : ($u->last_login_at ? 'Non-Aktif' : 'Belum Login') }}
                                                        </span>
                                                    @else
                                                        <span class="badge bg-secondary">Status tidak tersedia</span>
                                                    @endif
                                                    @if ($u->last_login_at)
                                                        <small class="text-muted mt-1">
                                                            {{ $u->last_login_at->timezone('Asia/Jakarta')->locale('id')->translatedFormat('d F Y H:i') }}
                                                        </small>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center text-muted">Belum ada pengguna</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="text-end mt-2">
                            <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-outline-primary">Lihat semua
                                pengguna</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
