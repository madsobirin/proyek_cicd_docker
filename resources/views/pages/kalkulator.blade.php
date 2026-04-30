@extends('layouts.main')

@section('title', $title)

@section('content')
    <div class="relative min-h-screen bg-background-base transition-colors duration-300">

        {{-- Overlay Guest --}}
        @guest
            <div class="absolute inset-0 z-50 flex items-center justify-center px-4 backdrop-blur-sm bg-background-base/30">
                <div class="w-full max-w-md p-8 text-center bg-card-dark border border-card-border rounded-2xl shadow-soft">
                    <div class="size-16 bg-primary/10 text-primary rounded-2xl flex items-center justify-center mx-auto mb-4">
                        <span class="material-icons-round text-3xl">lock</span>
                    </div>
                    <h4 class="text-2xl font-bold text-text-light mb-2">Akses Terbatas</h4>
                    <p class="text-text-muted mb-6 text-sm">Silakan login atau daftar akun FitLife terlebih dahulu untuk
                        menggunakan fitur Kalkulator BMI kami.</p>
                    <div class="flex flex-col gap-3">
                        <a href="{{ route('auth.login') }}"
                            class="w-full py-3 bg-primary text-background-base font-bold rounded-xl shadow-glow hover:bg-primary-hover transition-all">Masuk
                            / Daftar Sekarang</a>
                        <a href="{{ route('home') }}"
                            class="text-sm font-semibold text-text-muted hover:text-primary transition-colors">Kembali ke
                            Beranda</a>
                    </div>
                </div>
            </div>
        @endguest

        {{-- Content Wrapper: Pindah tag penutup ke paling bawah --}}
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 @guest kalk-locked-blur @endguest">

            {{-- Header --}}
            <div class="text-center mb-12">
                <div
                    class="size-16 bg-primary/10 text-primary rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-sm">
                    <span class="material-icons-round text-4xl">monitor_weight</span>
                </div>
                <h1 class="text-3xl md:text-5xl font-black tracking-tighter text-text-light mb-3">Kalkulator BMI</h1>
                <p class="text-text-muted max-w-2xl mx-auto">Hitung indeks massa tubuh Anda secara akurat untuk mengetahui
                    status berat badan ideal dan langkah kesehatan selanjutnya.</p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start mb-12">
                {{-- Form Input --}}
                <div class="lg:col-span-7 bg-card-dark border border-card-border rounded-2xl p-6 md:p-8 shadow-soft">
                    <h3 class="text-xl font-bold text-text-light mb-8 flex items-center gap-2">
                        <span class="material-icons-round text-primary">tune</span> Parameter Fisik
                    </h3>

                    <form action="{{ route('kalkulator') }}" method="POST" class="space-y-8">
                        @csrf
                        {{-- Gender Toggle --}}
                        <div>
                            <label class="block text-sm font-bold text-text-muted mb-4">Pilih Jenis Kelamin</label>
                            <div class="grid grid-cols-2 gap-4">
                                <label class="cursor-pointer">
                                    <input type="radio" name="gender" value="Pria" class="peer sr-only" checked>
                                    <div
                                        class="flex flex-col items-center justify-center p-4 border-2 border-card-border rounded-xl peer-checked:border-primary peer-checked:bg-primary/5 transition-all hover:border-primary/50">
                                        <span
                                            class="material-icons-round text-3xl mb-1 text-text-muted peer-checked:text-primary">male</span>
                                        <span
                                            class="text-sm font-bold text-text-muted peer-checked:text-text-light">Pria</span>
                                    </div>
                                </label>
                                <label class="cursor-pointer">
                                    <input type="radio" name="gender" value="Wanita" class="peer sr-only">
                                    <div
                                        class="flex flex-col items-center justify-center p-4 border-2 border-card-border rounded-xl peer-checked:border-primary peer-checked:bg-primary/5 transition-all hover:border-primary/50">
                                        <span
                                            class="material-icons-round text-3xl mb-1 text-text-muted peer-checked:text-primary">female</span>
                                        <span
                                            class="text-sm font-bold text-text-muted peer-checked:text-text-light">Wanita</span>
                                    </div>
                                </label>
                            </div>
                        </div>

                        {{-- Sliders --}}
                        <div class="space-y-6">
                            <div x-data="{ height: 170 }">
                                <div class="flex justify-between items-end mb-2">
                                    <label class="text-sm font-bold text-text-muted">Tinggi Badan</label>
                                    <div class="flex items-baseline gap-1">
                                        <span class="text-2xl font-black text-primary" x-text="height"></span>
                                        <span class="text-xs font-bold text-text-muted uppercase">cm</span>
                                    </div>
                                </div>
                                <input type="range" name="tinggi" min="100" max="250" x-model="height"
                                    class="w-full h-2">
                            </div>
                            <div x-data="{ weight: 65 }">
                                <div class="flex justify-between items-end mb-2">
                                    <label class="text-sm font-bold text-text-muted">Berat Badan</label>
                                    <div class="flex items-baseline gap-1">
                                        <span class="text-2xl font-black text-primary" x-text="weight"></span>
                                        <span class="text-xs font-bold text-text-muted uppercase">kg</span>
                                    </div>
                                </div>
                                <input type="range" name="berat" min="30" max="200" x-model="weight"
                                    class="w-full h-2">
                            </div>
                        </div>

                        <button type="submit"
                            class="w-full py-4 bg-primary text-background-base font-black rounded-xl shadow-glow hover:bg-primary-hover transition-all flex items-center justify-center gap-2">
                            <span class="material-icons-round">calculate</span> Hitung BMI Saya
                        </button>
                    </form>
                </div>

                {{-- Hasil & Info --}}
                <div class="lg:col-span-5 space-y-6">
                    @if (session('hasil'))
                        <div class="bg-card-dark border border-primary/30 rounded-2xl p-6 shadow-glow transition-all">
                            <h3 class="text-lg font-bold text-text-light mb-4 flex items-center gap-2">
                                <span class="material-icons-round text-primary">analytics</span> Hasil Analisis
                            </h3>
                            <div class="flex flex-col items-center">{!! session('hasil') !!}</div>
                        </div>
                    @else
                        <div class="bg-card-dark border border-card-border rounded-2xl p-6 shadow-soft">
                            <h3 class="text-lg font-bold text-text-light mb-4">Kenapa BMI Penting?</h3>
                            <p class="text-text-muted text-sm leading-relaxed mb-6">Body Mass Index (BMI) adalah standar
                                internasional untuk menentukan kategori berat badan ideal terhadap tinggi badan.</p>
                            <div class="space-y-3">
                                <div
                                    class="flex items-center gap-3 p-3 bg-background-base/50 rounded-lg border border-card-border">
                                    <span class="size-3 rounded-full bg-blue-400"></span><span
                                        class="text-xs font-bold text-text-muted">
                                        < 18.5 : Berat Badan Rendah</span>
                                </div>
                                <div
                                    class="flex items-center gap-3 p-4 bg-background-base/50 rounded-xl border border-card-border">
                                    <span class="size-3 rounded-full bg-primary"></span><span
                                        class="text-xs font-bold text-text-muted"> 18.5 – 24.9 : Normal (Ideal)</span>
                                </div>
                            </div>
                        </div>
                    @endif

                    {{-- Tips Card --}}
                    <div class="bg-primary/5 border border-primary/20 rounded-2xl p-6">
                        <div class="flex gap-3">
                            <span class="material-icons-round text-primary">lightbulb</span>
                            <div>
                                <h4 class="text-sm font-bold text-text-light mb-1">Tips Cepat Sehat</h4>
                                <ul class="text-xs text-text-muted space-y-2 list-disc ml-4 leading-relaxed">
                                    <li>Lakukan aktivitas fisik ringan minimal 30 menit sehari.</li>
                                    <li>Pastikan hidrasi tubuh tercukupi dengan minum air mineral 2L/hari.</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- BMI Classification Cards --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 animate-fade-in-up mb-12">
                <div
                    class="bg-card-dark border border-card-border p-6 rounded-2xl shadow-soft group hover:border-yellow-500/50 transition-all duration-300">
                    <div
                        class="w-12 h-12 bg-yellow-500/10 text-yellow-500 rounded-full flex items-center justify-center mb-4 transition-transform group-hover:scale-110">
                        <span class="material-icons-round">warning</span>
                    </div>
                    <h4 class="text-lg font-bold text-text-light mb-1">Kekurangan Berat</h4>
                    <p class="text-[10px] font-black text-text-muted mb-3 uppercase tracking-widest">BMI < 18.5</p>
                            <p class="text-xs text-text-muted leading-relaxed font-medium">Perlu menambah asupan kalori
                                bernutrisi dan latihan beban secara rutin.</p>
                </div>
                <div
                    class="bg-card-dark border border-primary/30 p-6 rounded-2xl shadow-soft group hover:border-primary transition-all duration-300 ring-1 ring-primary/20 scale-105 z-10">
                    <div
                        class="w-12 h-12 bg-primary/10 text-primary rounded-full flex items-center justify-center mb-4 transition-transform group-hover:scale-110">
                        <span class="material-icons-round">check_circle</span>
                    </div>
                    <h4 class="text-lg font-bold text-text-light mb-1">Normal (Ideal)</h4>
                    <p class="text-[10px] font-black text-primary mb-3 uppercase tracking-widest">BMI 18.5 - 24.9</p>
                    <p class="text-xs text-text-muted leading-relaxed font-medium">Pertahankan gaya hidup aktif dan pola
                        makan seimbang.</p>
                </div>
                <div
                    class="bg-card-dark border border-card-border p-6 rounded-2xl shadow-soft group hover:border-red-500/50 transition-all duration-300">
                    <div
                        class="w-12 h-12 bg-red-500/10 text-red-500 rounded-full flex items-center justify-center mb-4 transition-transform group-hover:scale-110">
                        <span class="material-icons-round">priority_high</span>
                    </div>
                    <h4 class="text-lg font-bold text-text-light mb-1">Kelebihan Berat</h4>
                    <p class="text-[10px] font-black text-text-muted mb-3 uppercase tracking-widest">BMI 25.0 - 29.9</p>
                    <p class="text-xs text-text-muted leading-relaxed font-medium">Disarankan untuk melakukan defisit
                        kalori ringan dan olahraga kardio rutin.</p>
                </div>
            </div>

            {{-- REKOMENDASI DI DALAM CONTAINER 7XL --}}
            @if (session('hasil'))
                <div class="mt-16 space-y-24 animate-fade-in-up">

                    {{-- Section Menu --}}
                    <div>
                        <div
                            class="flex flex-col md:flex-row md:items-end justify-between mb-8 border-b border-card-border pb-4">
                            <div>
                                <h3 class="text-2xl font-black text-text-light tracking-tight flex items-center gap-2">
                                    <span class="material-icons-round text-primary text-3xl">restaurant_menu</span>
                                    Menu Diet Khusus: {{ session('status_bmi') }}
                                </h3>
                                <p class="text-text-muted text-sm mt-1 leading-relaxed">Pilihan nutrisi terbaik untuk
                                    mendukung kondisi tubuh Anda saat ini.</p>
                            </div>
                            <a href="{{ route('menu', ['status' => session('status_bmi')]) }}"
                                class="mt-4 md:mt-0 text-primary font-bold hover:underline flex items-center gap-1 text-sm">
                                Lihat Semua Menu <span class="material-icons-round text-sm">arrow_forward</span>
                            </a>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                            @forelse (session('rekomendasi_menu') as $menu)
                                <div
                                    class="group bg-card-dark rounded-2xl overflow-hidden border border-card-border hover:border-primary/30 transition-all duration-300 shadow-sm hover:shadow-glow-soft">
                                    <div class="relative aspect-video overflow-hidden">
                                        <img src="{{ $menu->gambar ? Storage::url($menu->gambar) : asset('images/gambar_menu.jpg') }}"
                                            class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                                    </div>
                                    <div class="p-6">
                                        <h4
                                            class="font-bold text-text-light group-hover:text-primary transition-colors line-clamp-1 mb-3">
                                            {{ $menu->nama_menu }}</h4>
                                        <div
                                            class="flex items-center gap-4 text-[10px] font-black text-text-muted uppercase tracking-widest pt-4 border-t border-card-border">
                                            <span class="flex items-center gap-1"><span
                                                    class="material-icons-round text-primary text-sm">local_fire_department</span>
                                                {{ $menu->kalori }} Kkal</span>
                                            <span class="flex items-center gap-1"><span
                                                    class="material-icons-round text-primary text-sm">schedule</span>
                                                {{ $menu->waktu_memasak }} Min</span>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div
                                    class="col-span-full py-16 text-center bg-card-dark/40 border-2 border-dashed border-card-border/50 rounded-[2.5rem]">
                                    <span
                                        class="material-icons-round text-4xl text-text-muted/20 mb-3">restaurant_menu</span>
                                    <p class="text-text-muted text-sm italic">Belum ada menu diet khusus untuk kategori
                                        {{ session('status_bmi') }}.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>

                    {{-- Section Artikel - Versi Presisi & Dashed Empty State --}}

                </div>
        </div>
        @endif

    </div> {{-- Penutup Container max-w-7xl --}}

    </div> {{-- Penutup min-h-screen --}}
@endsection
