@extends('layouts.main')

@section('title', $title)
@section('content')
    <div class="bg-background-base min-h-screen transition-colors duration-300">
        {{-- Hero Detail --}}
        <section class="bg-background-dark py-16 transition-colors">
            <div class="max-w-4xl mx-auto px-4 text-center">
                <a href="{{ route('artikel.index') }}"
                    class="inline-flex items-center gap-2 text-primary hover:text-primary-hover font-bold text-xs uppercase tracking-widest mb-8 transition-all group">
                    <span class="material-icons-round transition-transform group-hover:-translate-x-1">arrow_back</span>
                    Kembali ke Artikel
                </a>
                <h1 class="text-3xl md:text-5xl font-black tracking-tighter text-text-light mb-6 leading-tight">
                    {{ $artikel->judul }}</h1>
                <div
                    class="flex flex-wrap justify-center items-center gap-6 text-xs font-bold text-text-muted uppercase tracking-widest">
                    <span class="flex items-center gap-2"><span
                            class="material-icons-round text-primary text-base">calendar_today</span>
                        {{ $artikel->created_at?->format('d M Y') }}</span>
                    <span class="flex items-center gap-2"><span
                            class="material-icons-round text-primary text-base">visibility</span> {{ $artikel->dibaca }}
                        Kali
                        Dibaca</span>
                    <span class="flex items-center gap-2"><span
                            class="material-icons-round text-primary text-base">person</span>
                        {{ $artikel->penulis ?? 'Admin' }}</span>
                </div>
            </div>
        </section>

        <div class="max-w-4xl mx-auto px-4 py-12 -mt-12 relative z-10">
            <div class="bg-card-dark rounded-3xl overflow-hidden shadow-soft border border-card-border">
                {{-- Main Image --}}
                <div class="relative h-75 md:h-125">
                    <img src="{{ $artikel->gambar ? Storage::url($artikel->gambar) : asset('images/sayuran.jpg') }}"
                        alt="{{ $artikel->judul }}" class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-linear-to-t from-card-dark/40 to-transparent"></div>
                </div>

                <div class="p-8 md:p-14">
                    {{-- Article Content --}}
                    <div class="prose prose-emerald max-w-none dark:prose-invert text-text-light leading-relaxed text-lg">
                        {!! $artikel->isi !!}
                    </div>

                    {{-- Share Section --}}
                    <div class="mt-16 pt-8 border-t border-card-border flex flex-wrap justify-between items-center gap-6">
                        <div class="flex items-center gap-4">
                            <span class="text-xs font-black text-text-muted uppercase tracking-widest">Bagikan:</span>
                            <button
                                class="size-10 rounded-xl border border-card-border flex items-center justify-center text-text-muted hover:text-primary hover:border-primary transition-all shadow-sm">
                                <span class="material-icons-round text-lg">share</span>
                            </button>
                        </div>
                        <div class="flex gap-2">
                            <span
                                class="bg-primary/10 text-primary text-[10px] font-black px-4 py-2 rounded-lg uppercase tracking-widest">
                                {{ $artikel->kategori ?? 'Kesehatan' }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Related Articles --}}
            @if (isset($artikels) && $artikels->count() > 1)
                <div class="mt-20">
                    <div class="flex items-center gap-3 mb-8">
                        <div class="h-8 w-1.5 bg-primary rounded-full"></div>
                        <h3 class="text-2xl font-black text-text-light tracking-tight">Artikel Lainnya</h3>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        @foreach ($artikels as $a)
                            @if ($a->id != $artikel->id)
                                <a href="{{ route('artikel.show', $a->slug) }}"
                                    class="group bg-card-dark border border-card-border p-4 rounded-2xl shadow-soft hover:border-primary/30 transition-all flex flex-col">
                                    <div class="relative aspect-video rounded-xl overflow-hidden mb-4">
                                        <img src="{{ $a->gambar ? Storage::url($a->gambar) : asset('images/sayuran.jpg') }}"
                                            class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                                            alt="Related">
                                    </div>
                                    <h4
                                        class="font-bold text-text-light text-sm line-clamp-2 group-hover:text-primary transition-colors leading-snug">
                                        {{ $a->judul }}
                                    </h4>
                                    <p class="text-[10px] text-text-muted mt-3 font-bold uppercase tracking-widest">
                                        {{ $a->created_at?->format('d M Y') }}
                                    </p>
                                </a>
                            @endif
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
