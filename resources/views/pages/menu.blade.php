@extends('layouts.main')

@section('title', $title)

@section('content')
    <div class="bg-background-base min-h-screen transition-colors duration-300">
        {{-- Hero Section --}}
        <header class="relative pt-16 pb-12 overflow-hidden">
            {{-- Background Pattern dari CSS --}}
            <div class="absolute inset-0 opacity-10 pointer-events-none"
                style="background-image: radial-gradient(var(--color-primary) 1px, transparent 1px); background-size: 24px 24px;">
            </div>

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
                <div
                    class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-primary/10 text-primary text-sm font-bold mb-6">
                    <span class="material-icons-round text-base">verified</span>
                    FitLife Premium Menu
                </div>
                <h1 class="text-4xl md:text-6xl font-black tracking-tighter text-text-light mb-4">
                    Menu Sehat <span class="text-primary">Premium</span>
                </h1>
                <p class="text-lg text-text-muted max-w-2xl mx-auto mb-10 leading-relaxed">
                    Koleksi resep terkurasi oleh ahli gizi untuk mendukung target kalori dan gaya hidup sehat Anda setiap
                    hari.
                </p>

                {{-- Ganti bagian search bar dengan ini --}}
                <form action="{{ route('menu') }}" method="GET" class="max-w-2xl mx-auto relative group">
                    <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none">
                        <span
                            class="material-icons-round text-text-muted group-focus-within:text-primary transition-colors">search</span>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}"
                        class="block w-full pl-14 pr-4 py-4 rounded-2xl border-none shadow-soft bg-card-dark text-text-light placeholder-text-muted/50 focus:ring-2 focus:ring-primary transition-all"
                        placeholder="Cari resep atau bahan makanan...">
                    <button type="submit"
                        class="absolute right-2.5 top-2.5 bottom-2.5 bg-primary hover:bg-primary-hover text-background-base px-6 rounded-xl font-bold transition-all shadow-glow">
                        Cari
                    </button>
                </form>
            </div>
        </header>

        <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-24">
            {{-- Featured Recommendation (First Item) --}}
            @if ($menus->isNotEmpty())
                @php $featured = $menus->first(); @endphp
                <div
                    class="mb-16 relative rounded-3xl overflow-hidden shadow-soft bg-card-dark border border-card-border group">
                    <div class="grid md:grid-cols-2 gap-0 items-center">
                        <div class="p-8 md:p-12 relative z-10">
                            <div
                                class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-primary/10 text-primary text-[10px] font-black uppercase tracking-widest mb-4">
                                Rekomendasi Hari Ini
                            </div>
                            <h2
                                class="text-3xl md:text-4xl font-black mb-4 text-text-light leading-tight group-hover:text-primary transition-colors">
                                {{ $featured->nama_menu }}
                            </h2>
                            <div class="text-text-muted mb-8 leading-relaxed line-clamp-3">
                                {!! $featured->deskripsi !!}
                            </div>
                            <div class="flex items-center gap-4 mb-8">
                                <div
                                    class="flex items-center gap-2 bg-background-base px-4 py-2 rounded-xl border border-card-border shadow-sm">
                                    <span class="material-icons-round text-primary text-lg">local_fire_department</span>
                                    <span class="text-sm font-bold text-text-light">{{ $featured->kalori ?? '0' }}
                                        kkal</span>
                                </div>
                                <div
                                    class="flex items-center gap-2 bg-background-base px-4 py-2 rounded-xl border border-card-border shadow-sm">
                                    <span class="material-icons-round text-primary text-lg">schedule</span>
                                    <span class="text-sm font-bold text-text-light">{{ $featured->waktu_memasak ?? '0' }}
                                        mnt</span>
                                </div>
                            </div>
                            <a href="{{ route('menu.show', $featured->id) }}"
                                class="inline-flex items-center gap-2 bg-primary hover:bg-primary-hover text-background-base px-8 py-4 rounded-xl font-bold transition-all shadow-glow hover:-translate-y-1">
                                Lihat Resep Lengkap
                                <span class="material-icons-round text-xl">arrow_forward</span>
                            </a>
                        </div>
                        <div class="h-80 md:h-full relative overflow-hidden">
                            <img src="{{ $featured->gambar ? Storage::url($featured->gambar) : asset('images/salad.jpg') }}"
                                class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105"
                                alt="Featured Menu">
                        </div>
                    </div>
                </div>
            @endif

            @if (request('status'))
                <div class="mb-8 p-4 bg-primary/10 border border-primary/20 rounded-2xl flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <span class="material-icons-round text-primary">auto_awesome</span>
                        <div>
                            <h4 class="text-sm font-bold text-text-light">Menu Rekomendasi Untuk Anda</h4>
                            <p class="text-xs text-text-muted">Menampilkan menu yang cocok untuk status BMI:
                                <strong>{{ request('status') }}</strong></p>
                        </div>
                    </div>
                    <a href="{{ route('menu') }}" class="text-xs font-bold text-primary hover:underline text-right">Hapus
                        Filter</a>
                </div>
            @endif

            {{-- Menu Grid --}}
            <div class="flex justify-between items-end mb-8">
                <div>
                    <h3 class="text-2xl font-black text-text-light tracking-tight">Katalog Menu Terbaru</h3>
                    <p class="text-text-muted text-sm mt-1">Pilihan menu bergizi untuk kebutuhan nutrisi harian Anda.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse ($menus as $item)
                    <div
                        class="group bg-card-dark rounded-2xl overflow-hidden border border-card-border shadow-sm hover:shadow-soft hover:border-primary/30 transition-all duration-300 hover:-translate-y-1">
                        <div class="relative aspect-video overflow-hidden">
                            <img src="{{ $item->gambar ? Storage::url($item->gambar) : asset('images/gambar_menu.jpg') }}"
                                class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110"
                                alt="{{ $item->nama_menu }}">
                            <div class="absolute top-3 right-3">
                                <button
                                    class="p-2 bg-background-base/80 backdrop-blur-md rounded-full text-text-muted hover:text-red-500 transition-colors shadow-sm">
                                    <span class="material-icons-round text-xl">favorite_border</span>
                                </button>
                            </div>
                        </div>
                        <div class="p-6">
                            <div class="flex justify-between items-start mb-3">
                                <h4
                                    class="font-bold text-lg text-text-light leading-snug group-hover:text-primary transition-colors">
                                    {{ $item->nama_menu }}</h4>
                                <span
                                    class="bg-primary/10 text-primary text-[10px] font-black px-2 py-1 rounded uppercase tracking-widest">Premium</span>
                            </div>
                            <div class="text-text-muted text-xs mb-6 line-clamp-2 leading-relaxed">
                                {!! strip_tags($item->deskripsi) !!}
                            </div>
                            <div class="flex items-center justify-between pt-4 border-t border-card-border">
                                <div class="flex items-center gap-4 text-[11px] font-bold text-text-muted">
                                    <span class="flex items-center gap-1.5"><span
                                            class="material-icons-round text-primary text-sm">local_fire_department</span>
                                        {{ $item->kalori ?? '0' }} kkal</span>
                                    <span class="flex items-center gap-1.5"><span
                                            class="material-icons-round text-primary text-sm">schedule</span>
                                        {{ $item->waktu_memasak ?? '0' }}m</span>
                                </div>
                                <a href="{{ route('menu.show', $item->id) }}"
                                    class="p-2 bg-primary/5 text-primary rounded-lg hover:bg-primary hover:text-background-base transition-all">
                                    <span class="material-icons-round text-lg">arrow_forward</span>
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    {{-- EMPTY STATE: Tampilan jika menu tidak ada --}}
                    <div class="col-span-full py-20 text-center animate-fade-in-up">
                        <div
                            class="size-24 bg-card-dark border border-card-border rounded-3xl flex items-center justify-center mx-auto mb-6 shadow-soft">
                            <span class="material-icons-round text-5xl text-text-muted/30">restaurant_menu</span>
                        </div>
                        <h4 class="text-xl font-bold text-text-light mb-2">Belum ada menu tersedia</h4>
                        <p class="text-text-muted text-sm max-w-xs mx-auto">Kami sedang meracik menu kesehatan baru untuk
                            Anda. Silakan kembali lagi nanti!</p>
                    </div>
                @endforelse
            </div>
        </main>
    </div>
@endsection
