@extends('layouts.main')

@section('title', $title)

@section('content')
    <div class="bg-background-base min-h-screen transition-colors duration-300">
        {{-- Hero Header --}}
        <section class="bg-background-dark py-12 transition-colors">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <nav class="flex justify-center mb-6">
                    <a href="{{ route('menu') }}"
                        class="flex items-center gap-2 text-primary hover:text-primary-hover font-bold text-sm transition-all group">
                        <span class="material-icons-round transition-transform group-hover:-translate-x-1">arrow_back</span>
                        Kembali ke Katalog
                    </a>
                </nav>
                <h2 class="text-3xl md:text-5xl font-black tracking-tighter text-text-light mb-4">{{ $menu->nama_menu }}</h2>
                <div
                    class="flex justify-center items-center gap-6 text-xs font-bold text-text-muted uppercase tracking-widest">
                    <span class="flex items-center gap-2"><span
                            class="material-icons-round text-primary text-sm">calendar_today</span>
                        {{ $menu->created_at?->format('d M Y') }}</span>
                    <span class="flex items-center gap-2"><span
                            class="material-icons-round text-primary text-sm">visibility</span> {{ $menu->dibaca }}
                        Kali</span>
                </div>
            </div>
        </section>

        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12 -mt-8">
            <div class="bg-card-dark rounded-3xl overflow-hidden shadow-soft border border-card-border">
                {{-- Detail Image --}}
                <div class="relative h-75 md:h-125">
                    <img src="{{ $menu->gambar ? Storage::url($menu->gambar) : asset('images/salad.jpg') }}"
                        alt="{{ $menu->nama_menu }}" class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-linear-to-t from-card-dark/60 to-transparent"></div>
                </div>

                <div class="p-8 md:p-12 relative">
                    {{-- Nutrition Badges --}}
                    <div class="flex flex-wrap gap-4 mb-10 -mt-20 relative z-10">
                        <div
                            class="bg-card-dark border border-card-border p-4 rounded-2xl shadow-soft flex items-center gap-4">
                            <div class="size-10 bg-primary/10 text-primary rounded-xl flex items-center justify-center">
                                <span class="material-icons-round">local_fire_department</span>
                            </div>
                            <div>
                                <p class="text-[10px] font-black text-text-muted uppercase tracking-widest">Kalori</p>
                                <p class="text-lg font-black text-text-light">{{ $menu->kalori ?? '0' }} <span
                                        class="text-xs">kkal</span></p>
                            </div>
                        </div>
                        <div
                            class="bg-card-dark border border-card-border p-4 rounded-2xl shadow-soft flex items-center gap-4">
                            <div class="size-10 bg-primary/10 text-primary rounded-xl flex items-center justify-center">
                                <span class="material-icons-round">schedule</span>
                            </div>
                            <div>
                                <p class="text-[10px] font-black text-text-muted uppercase tracking-widest">Waktu</p>
                                <p class="text-lg font-black text-text-light">{{ $menu->waktu_memasak ?? '0' }} <span
                                        class="text-xs">mnt</span></p>
                            </div>
                        </div>
                    </div>

                    {{-- Main Content --}}
                    <div class="prose prose-emerald max-w-none dark:prose-invert">
                        <h3 class="text-2xl font-black text-text-light mb-6 tracking-tight">Cara Menyiapkan Menu Ini</h3>
                        <div class="text-text-muted leading-relaxed text-lg space-y-6">
                            {!! $menu->deskripsi !!}
                        </div>
                    </div>

                    {{-- Interactive Footer --}}
                    <div class="mt-16 pt-8 border-t border-card-border flex flex-wrap justify-between items-center gap-6">
                        <div class="flex items-center gap-4">
                            <span class="text-sm font-bold text-text-light">Bagikan:</span>
                            <button
                                class="size-10 rounded-full border border-card-border flex items-center justify-center text-text-muted hover:text-primary hover:border-primary transition-all">
                                <span class="material-icons-round text-lg">share</span>
                            </button>
                            <button
                                class="size-10 rounded-full border border-card-border flex items-center justify-center text-text-muted hover:text-red-500 hover:border-red-500 transition-all">
                                <span class="material-icons-round text-lg">favorite</span>
                            </button>
                        </div>
                        <a href="{{ route('kalkulator') }}"
                            class="inline-flex items-center gap-2 bg-primary/10 text-primary px-6 py-3 rounded-xl font-bold text-sm hover:bg-primary hover:text-background-base transition-all">
                            Cocokkan dengan BMI Anda
                            <span class="material-icons-round">trending_up</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
