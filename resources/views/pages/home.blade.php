@extends('layouts.main')

@section('title', $title)

@section('content')

    {{-- Hero Section --}}
    <section
        class="relative bg-background-base pt-12 pb-20 lg:pt-24 lg:pb-32 overflow-hidden transition-colors duration-300">
        {{-- Overlay gradasi disesuaikan agar tidak terlalu gelap di mode terang --}}
        <div
            class="absolute inset-0 bg-linear-to-br from-background-dark/20 via-background-base to-background-dark/20 opacity-80 pointer-events-none">
        </div>

        <div class="absolute top-0 right-0 w-1/2 h-full bg-primary/5 filter blur-[120px] rounded-full pointer-events-none">
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="flex flex-col lg:flex-row items-center gap-12">
                <div class="w-full lg:w-1/2 text-left">
                    <span
                        class="inline-block px-4 py-1.5 rounded-full bg-card-dark border border-card-border text-primary text-sm font-bold tracking-wide uppercase mb-6 shadow-sm">
                        Hidup lebih sehat dan bahagia
                    </span>
                    {{-- text-white diganti ke text-text-light agar bisa jadi hitam di mode terang --}}
                    <h1 class="text-4xl lg:text-6xl font-extrabold leading-tight mb-6 text-text-light">
                        Selamat Datang di <span
                            class="text-transparent bg-clip-text bg-linear-to-r from-primary to-green-400">Fitlife.id</span>
                    </h1>
                    <p class="text-lg text-text-muted mb-8 leading-relaxed max-w-xl">
                        Platform manajemen diet dan pola makan digital untuk hidup yang lebih sehat dengan menu lezat,
                        artikel inspiratif, dan kalkulator BMI.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-start">
                        {{-- Tombol utama tetap hijau, teks mengikuti warna background base agar kontras --}}
                        <a class="bg-primary text-background-base hover:bg-primary-hover px-8 py-3.5 rounded-full font-bold shadow-glow transition transform hover:-translate-y-1 text-center"
                            href="#">
                            Mulai Sekarang
                        </a>
                        <a class="bg-transparent border border-card-border hover:border-primary text-text-light hover:text-primary px-8 py-3.5 rounded-full font-bold transition text-center"
                            href="#">
                            Pelajari Lebih Lanjut
                        </a>
                    </div>
                </div>
                <div class="w-full lg:w-1/2 relative group">
                    <div
                        class="absolute inset-0 bg-primary/20 rounded-3xl transform rotate-3 scale-95 opacity-0 group-hover:opacity-100 transition-opacity duration-500 blur-2xl">
                    </div>
                    <img alt="Fresh vegetables"
                        class="relative rounded-3xl shadow-2xl border border-card-border object-cover w-full h-100 lg:h-125 transform transition duration-500 hover:scale-[1.01]"
                        src="https://lh3.googleusercontent.com/aida-public/AB6AXuDQ4ZkSFClO1fXtFbM0XmO9HaCa_r9xNW8tboOEpzU7LBjEFr5MPX4c86KmN2zBDe6d_YoFLQVSQ8A05NFXJEdmxFjW4rakGfhZleToMRiI8UAtyHgiXcg4cLOpsjuifCjLKlfYK-f4nZ5SdfmAy-FXZ0pOfr1n2CUBYI3h5myPjfEaNdOSnDRu-HUcTPQX59IVEidQcadhat-aKa25U7WoftnrqckvkVyf84ERzpSltf24cU-EJFf78t3LWPE77S3ylwfSmnh3JNY" />
                </div>
            </div>
        </div>
    </section>

    {{-- Features Section --}}
    <section class="py-20 bg-background-base transition-colors duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-text-light mb-4">Fitur Unggulan FitLife.id</h2>
                <p class="text-text-muted text-lg">
                    Dapatkan semua yang anda butuhkan untuk mencapai tujuan kesehatan anda
                </p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                {{-- Card menggunakan bg-card-dark yang sudah kita set dinamis di CSS --}}
                @foreach ([['icon' => 'show_chart', 'title' => 'Kalkulator BMI', 'desc' => 'Hitung indeks massa tubuh anda.', 'route' => 'kalkulator'], ['icon' => 'restaurant_menu', 'title' => 'Menu Sehat', 'desc' => 'Temukan berbagai pilihan menu makanan sehat.', 'route' => 'menu'], ['icon' => 'article', 'title' => 'Artikel', 'desc' => 'Baca artikel dan tips seputar diet sehat.', 'route' => 'artikel.index']] as $item)
                    <div
                        class="bg-card-dark rounded-2xl p-8 shadow-soft border border-card-border flex flex-col items-center text-center group hover:border-primary/50 transition-all duration-300">
                        <div
                            class="w-16 h-16 bg-background-base text-primary border border-card-border rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                            <span class="material-icons-round text-3xl">{{ $item['icon'] }}</span>
                        </div>
                        <h3 class="text-xl font-bold text-text-light mb-3">{{ $item['title'] }}</h3>
                        <p class="text-text-muted mb-8 grow italic">{{ $item['desc'] }}</p>
                        <a class="w-full bg-transparent border border-primary text-primary hover:bg-primary hover:text-background-base py-3 rounded-xl font-bold transition"
                            href="{{ route($item['route']) }}">
                            Lihat Detail
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Section tanpa border-t --}}
    <section class="py-16 bg-background-base transition-colors duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-2 gap-8">

                <div class="bg-card-dark rounded-2xl p-6 shadow-soft">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-xl font-bold text-text-light flex items-center gap-2">
                            <span class="material-icons-round text-primary">restaurant_menu</span>
                            Menu Sehat Terbaru
                        </h3>
                        <a class="text-primary text-sm font-semibold hover:text-primary-hover transition flex items-center gap-1"
                            href="{{ route('menu') }}">
                            Lihat semua <span class="material-icons-round text-xs">arrow_forward</span>
                        </a>
                    </div>

                    <div class="space-y-4">
                        @forelse($featuredMenus as $menu)
                            {{-- Item: Mengubah 'border border-transparent' menjadi 'border-none' agar lebih bersih --}}
                            <a href="{{ route('menu.show', $menu->id) }}"
                                class="flex items-center gap-4 p-3 rounded-xl hover:bg-primary/5 transition-all group">
                                <div class="size-14 rounded-lg overflow-hidden shrink-0">
                                    <img src="{{ $menu->gambar ? Storage::url($menu->gambar) : asset('images/gambar_menu.jpg') }}"
                                        class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                </div>
                                <div class="grow">
                                    <h4
                                        class="text-sm font-bold text-text-light group-hover:text-primary transition-colors line-clamp-1">
                                        {{ $menu->nama_menu }}
                                    </h4>
                                    <div
                                        class="flex items-center gap-3 mt-1 text-[10px] font-black text-text-muted uppercase tracking-tighter">
                                        <span class="flex items-center gap-1">
                                            <span
                                                class="material-icons-round text-primary text-[14px]">local_fire_department</span>
                                            {{ $menu->kalori ?? '0' }} Kkal
                                        </span>
                                        <span class="flex items-center gap-1">
                                            <span class="material-icons-round text-primary text-[14px]">schedule</span>
                                            {{ $menu->waktu_memasak ?? '0' }}m
                                        </span>
                                    </div>
                                </div>
                                <span
                                    class="material-icons-round text-text-muted/30 group-hover:text-primary group-hover:translate-x-1 transition-all">chevron_right</span>
                            </a>
                        @empty
                            <div
                                class="h-32 flex flex-col items-center justify-center text-text-muted italic bg-background-dark/30 rounded-xl text-sm border border-dashed border-card-border">
                                <span class="material-icons-round mb-2 opacity-10 text-4xl">no_meals</span>
                                Belum ada menu yang tersedia.
                            </div>
                        @endforelse
                    </div>
                </div>

                {{-- Card Artikel: Menghapus 'border border-card-border' --}}
                <div class="bg-card-dark rounded-2xl p-6 shadow-soft">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-xl font-bold text-text-light flex items-center gap-2">
                            <span class="material-icons-round text-primary">article</span>
                            Artikel Terbaru
                        </h3>
                        <a class="text-primary text-sm font-semibold hover:text-primary-hover transition flex items-center gap-1"
                            href="{{ route('artikel.index') }}">
                            Lihat semua <span class="material-icons-round text-xs">arrow_forward</span>
                        </a>
                    </div>

                    <div class="space-y-4">
                        @forelse($latestArticles as $artikel)
                            <a href="{{ route('artikel.show', $artikel->slug) }}"
                                class="flex items-center gap-4 p-3 rounded-xl hover:bg-primary/5 transition-all group">
                                <div class="size-14 rounded-lg overflow-hidden shrink-0">
                                    <img src="{{ $artikel->gambar ? Storage::url($artikel->gambar) : asset('images/default-article.jpg') }}"
                                        class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                </div>
                                <div class="grow">
                                    <span class="text-[9px] font-black text-primary uppercase tracking-widest mb-1 block">
                                        {{ $artikel->kategori }}
                                    </span>
                                    <h4
                                        class="text-sm font-bold text-text-light group-hover:text-primary transition-colors line-clamp-1">
                                        {{ $artikel->judul }}
                                    </h4>
                                </div>
                                <span
                                    class="material-icons-round text-text-muted/30 group-hover:text-primary group-hover:translate-x-1 transition-all">chevron_right</span>
                            </a>
                        @empty
                            <div
                                class="h-32 flex flex-col items-center justify-center text-text-muted italic bg-background-dark/30 rounded-xl text-sm border border-dashed border-card-border">
                                <span class="material-icons-round mb-2 opacity-10 text-4xl">description</span>
                                Belum ada artikel.
                            </div>
                        @endforelse
                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- Footer --}}
    <footer class="bg-background-base pt-12 pb-8 border-t border-card-border transition-colors duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-4 gap-8 mb-8">
                <div class="col-span-1 md:col-span-2">
                    <div class="flex items-center gap-2 mb-4">
                        <div
                            class="bg-primary text-background-base p-1 rounded font-bold text-lg h-7 w-7 flex items-center justify-center">
                            F</div>
                        <span class="font-bold text-xl text-text-light">FitLife.id</span>
                    </div>
                    <p class="text-text-muted text-sm max-w-xs">
                        Platform kesehatan terpercaya untuk membantu Anda mencapai berat badan ideal dan gaya hidup sehat.
                    </p>
                </div>
                <div>
                    <h4 class="font-bold text-text-light mb-4">Navigasi</h4>
                    <ul class="space-y-2 text-sm text-text-muted">
                        <li><a class="hover:text-primary transition" href="#">Home</a></li>
                        <li><a class="hover:text-primary transition" href="#">Kalkulator BMI</a></li>
                        <li><a class="hover:text-primary transition" href="#">Menu Sehat</a></li>
                        <li><a class="hover:text-primary transition" href="#">Artikel</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold text-text-light mb-4">Hubungi Kami</h4>
                    <ul class="space-y-2 text-sm text-text-muted">
                        <li>support@fitlife.id</li>
                        <li>+62 812 3456 7890</li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-card-border pt-8 text-center text-sm text-text-muted">
                © {{ date('Y') }} FitLife.id. All rights reserved.
            </div>
        </div>
    </footer>

@endsection
