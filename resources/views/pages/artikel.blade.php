@extends('layouts.main')

@section('title', $title)

@section('content')
    <div class="bg-background-base min-h-screen transition-colors duration-300">
        {{-- Hero Section --}}
        <header class="relative py-20 overflow-hidden">
            <div class="absolute inset-0 z-0 opacity-10 pointer-events-none"
                style="background-image: radial-gradient(var(--color-primary) 1px, transparent 1px); background-size: 24px 24px;">
            </div>

            {{-- Gradasi lembut untuk menambah dimensi tanpa mengganggu teks --}}
            <div class="absolute inset-0 bg-linear-to-br from-primary/10 to-primary/20 opacity-50 pointer-events-none"></div>

            {{-- Elemen dekoratif tambahan --}}
            <div class="absolute top-10 left-10 w-24 h-24 bg-primary/20 rounded-full blur-3xl animate-pulse"></div>
            <div class="absolute bottom-10 right-10 w-32 h-32 bg-primary/30 rounded-full blur-3xl animate-pulse delay-2000">
            </div>

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">

                <div class="max-w-4xl mx-auto text-center px-4 relative z-10">
                    <span class="inline-block p-3 rounded-full bg-primary/10 text-primary mb-6 animate-bounce">
                        <span class="material-icons-round text-3xl">auto_stories</span>
                    </span>
                    <h1 class="text-4xl md:text-6xl font-black text-text-light mb-6 tracking-tighter">
                        Artikel Diet & <span class="text-primary">Kesehatan</span>
                    </h1>
                    <p class="text-lg text-text-muted mb-10 max-w-2xl mx-auto leading-relaxed">
                        Temukan wawasan terbaru seputar nutrisi, gaya hidup, dan tips praktis dari para ahli untuk
                        transformasi
                        tubuh Anda.
                    </p>

                    {{-- Search Bar Kategori --}}
                    <form action="{{ route('artikel.index') }}" method="GET" class="max-w-2xl mx-auto relative group">
                        <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none">
                            <span
                                class="material-icons-round text-text-muted group-focus-within:text-primary transition-colors">search</span>
                        </div>
                        <input type="text" name="kategori" value="{{ request('kategori') }}"
                            class="block w-full pl-14 pr-4 py-4 rounded-2xl border-none shadow-soft bg-card-dark text-text-light placeholder-text-muted/50 focus:ring-2 focus:ring-primary transition-all"
                            placeholder="Cari kategori (misal: Diet, Olahraga)...">
                        <button type="submit"
                            class="absolute right-2.5 top-2.5 bottom-2.5 bg-primary hover:bg-primary-hover text-background-base px-6 rounded-xl font-bold transition-all shadow-glow">
                            Cari
                        </button>
                    </form>
                </div>
        </header>

        <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            {{-- Featured Article --}}
            @if ($featured)
                <div class="mb-16 bg-card-dark rounded-3xl shadow-soft overflow-hidden border border-card-border group">
                    <div class="grid grid-cols-1 lg:grid-cols-2">
                        <div class="relative h-72 lg:h-auto overflow-hidden">
                            <img src="{{ $featured->gambar ? Storage::url($featured->gambar) : asset('images/jus buah.jpg') }}"
                                class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-105"
                                alt="Featured">
                            <span
                                class="absolute top-4 left-4 bg-primary text-background-base text-[10px] font-black px-3 py-1 rounded-full uppercase tracking-widest">
                                Unggulan
                            </span>
                        </div>
                        <div class="p-8 lg:p-12 flex flex-col justify-center">
                            <div class="flex items-center text-xs font-bold text-text-muted mb-4 space-x-4">
                                <span class="flex items-center"><span
                                        class="material-icons-round text-base mr-1">schedule</span>
                                    {{ $featured->created_at?->format('d M Y') }}</span>
                                <span class="flex items-center"><span
                                        class="material-icons-round text-base mr-1">visibility</span>
                                    {{ $featured->dibaca }}
                                    views</span>
                            </div>
                            <h3
                                class="text-3xl font-black text-text-light mb-4 leading-tight group-hover:text-primary transition-colors">
                                {{ $featured->judul }}
                            </h3>
                            <p class="text-text-muted mb-8 line-clamp-3 leading-relaxed">
                                {!! Str::limit(strip_tags($featured->isi), 200) !!}
                            </p>
                            <div class="flex items-center justify-between mt-auto">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="size-10 rounded-full bg-primary/20 flex items-center justify-center text-primary font-bold">
                                        A</div>
                                    <div>
                                        <p class="text-sm font-bold text-text-light">Tim FitLife</p>
                                        <p class="text-[10px] text-text-muted uppercase font-bold tracking-widest">Editor
                                        </p>
                                    </div>
                                </div>
                                <a href="{{ route('artikel.show', $featured->slug) }}"
                                    class="inline-flex items-center text-primary font-bold hover:gap-3 transition-all">
                                    Baca Selengkapnya <span class="material-icons-round ml-1 text-sm">arrow_forward</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            {{-- Article Grid --}}
            <div class="flex items-center justify-between mb-8 border-l-4 border-primary pl-4">
                <h2 class="text-2xl font-black text-text-light tracking-tight">Artikel Terbaru</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-20">
                @forelse($artikels as $a)
                    @if ($featured && $featured->id === $a->id)
                        @continue
                    @endif
                    <article
                        class="bg-card-dark rounded-2xl shadow-soft border border-card-border overflow-hidden group hover:border-primary/30 hover:-translate-y-2 transition-all duration-300 flex flex-col h-full">
                        <div class="relative h-56 overflow-hidden">
                            <img src="{{ $a->gambar ? Storage::url($a->gambar) : asset('images/sayuran.jpg') }}"
                                class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110"
                                alt="Article">
                            <span
                                class="absolute top-3 left-3 bg-background-base/90 backdrop-blur-md text-text-light text-[10px] font-black px-3 py-1 rounded-lg shadow-sm uppercase tracking-widest">
                                {{ $a->kategori ?? 'Kesehatan' }}
                            </span>
                        </div>
                        <div class="p-6 flex flex-col grow">
                            <h3
                                class="text-xl font-bold text-text-light mb-3 group-hover:text-primary transition-colors line-clamp-2 leading-snug">
                                {{ $a->judul }}
                            </h3>
                            <p class="text-text-muted text-sm mb-6 line-clamp-3 leading-relaxed">
                                {!! Str::limit(strip_tags($a->isi), 120) !!}
                            </p>
                            <div class="mt-auto flex items-center justify-between pt-4 border-t border-card-border">
                                <div
                                    class="flex items-center text-[11px] font-bold text-text-muted uppercase tracking-wider">
                                    <span class="material-symbols-rounded text-sm mr-1">person</span>
                                    {{ $a->penulis ?? 'FitLife' }}
                                </div>
                                <a href="{{ route('artikel.show', $a->slug) }}"
                                    class="text-primary group-hover:translate-x-1 transition-transform">
                                    <span class="material-icons-round">arrow_forward</span>
                                </a>
                            </div>
                        </div>
                    </article>
                @empty
                    {{-- EMPTY STATE --}}
                    <div class="col-span-full py-24 text-center">
                        <div
                            class="size-24 bg-card-dark border border-card-border rounded-3xl flex items-center justify-center mx-auto mb-6 shadow-soft text-text-muted/20">
                            <span class="material-symbols-rounded text-5xl">find_in_page</span>
                        </div>
                        <h4 class="text-xl font-bold text-text-light mb-2">Artikel Tidak Ditemukan</h4>
                        <p class="text-text-muted text-sm max-w-xs mx-auto">Kami tidak menemukan artikel untuk kategori
                            "{{ request('kategori') }}". Coba gunakan kata kunci lain.</p>
                    </div>
                @endforelse
            </div>
        </main>
    </div>
@endsection
