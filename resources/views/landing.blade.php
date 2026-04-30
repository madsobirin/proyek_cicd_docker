<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FitLife.id - Hidup Sehat Lebih Mudah</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-green-50 font-sans text-gray-800">

    {{-- NAVBAR --}}
    <nav class="flex justify-between items-center px-8 py-4 bg-white shadow-sm">
        <div class="flex items-center space-x-2">
            <img src="{{ asset('img/logo.png') }}" alt="FitLife Logo" class="h-8 w-8">
            <h1 class="text-2xl font-bold text-green-600">FitLife.id</h1>
        </div>

        <div class="space-x-3">
            @auth
                <span class="font-semibold text-green-600">
                    Selamat datangg, {{ Auth::user()->nama_lengkap ?? Auth::user()->username }}
                </span>

                <a href={{ route('test.profile') }}
                    class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                    Profil
                </a>

                <a href="/logout" class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition">
                    Logout
                </a>
            @else
                <a href="/auth?tab=login"
                    class="px-4 py-2 border border-green-600 text-green-600 rounded-lg hover:bg-green-600 hover:text-white transition">
                    Login
                </a>

                <a href="/auth?tab=register"
                    class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                    Daftar
                </a>
            @endauth
        </div>
    </nav>


    {{-- HERO SECTION --}}
    <section class="relative bg-green-600 text-white text-center py-24 overflow-hidden">
        <div class="absolute inset-0 bg-cover bg-center opacity-20"
            style="background-image: url('{{ asset('img/healthy-bg.jpg') }}')"></div>

        <div class="relative z-10 max-w-3xl mx-auto">

            @auth
                <h1 class="text-4xl font-extrabold mb-4">
                    Selamat Datang,
                    <span class="text-yellow-200">
                        {{ Auth::user()->nama_lengkap ?? Auth::user()->username }}
                    </span>
                </h1>
                <p class="text-lg mb-8">Senang melihatmu kembali! Mulai perjalanan sehatmu hari ini 💚</p>
            @else
                <h1 class="text-4xl font-extrabold mb-4">
                    Selamat Datang di <span class="text-yellow-200">FitLife.id</span>
                </h1>
                <p class="text-lg mb-8">
                    Platform manajemen diet dan pola makan digital untuk hidup yang lebih sehat dan bahagia
                </p>

                <div class="space-x-4">
                    <a href="/auth?tab=register"
                        class="bg-white text-green-700 px-6 py-3 rounded-lg font-semibold hover:bg-green-100 transition">
                        Mulai Sekarang
                    </a>
                    <a href="#fitur"
                        class="border border-white px-6 py-3 rounded-lg font-semibold hover:bg-white hover:text-green-700 transition">
                        Pelajari Lebih Lanjut →
                    </a>
                </div>
            @endauth

        </div>
    </section>


    {{-- FITUR --}}
    <section id="fitur" class="py-16 text-center bg-white">
        <h2 class="text-3xl font-bold mb-2 text-green-700">Fitur Unggulan FitLife.id</h2>
        <p class="text-gray-500 mb-10">Dapatkan semua yang anda butuhkan untuk mencapai tujuan kesehatan anda</p>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-6xl mx-auto px-6">

            {{-- BMI --}}
            <div class="bg-white shadow-lg rounded-2xl p-6 hover:shadow-xl transition">
                <div class="text-green-600 text-5xl mb-3">📱</div>
                <h3 class="text-xl font-bold mb-2">Kalkulator BMI</h3>
                <p class="text-gray-500 mb-4">Hitung indeks massa tubuh Anda dan dapatkan rekomendasi ideal</p>

                <a href="@auth /bmi @else /auth?tab=login @endauth"
                    class="inline-block bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition">
                    Lihat Detail →
                </a>
            </div>

            {{-- MENU SEHAT --}}
            <div class="bg-white shadow-lg rounded-2xl p-6 hover:shadow-xl transition">
                <div class="text-green-600 text-5xl mb-3">🥗</div>
                <h3 class="text-xl font-bold mb-2">Menu Sehat</h3>
                <p class="text-gray-500 mb-4">Temukan berbagai pilihan menu makanan sehat</p>

                <a href="@auth /menu @else /auth?tab=login @endauth"
                    class="inline-block bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition">
                    Lihat Detail →
                </a>
            </div>

            {{-- ARTIKEL --}}
            <div class="bg-white shadow-lg rounded-2xl p-6 hover:shadow-xl transition">
                <div class="text-green-600 text-5xl mb-3">📖</div>
                <h3 class="text-xl font-bold mb-2">Artikel</h3>
                <p class="text-gray-500 mb-4">Baca artikel dan tips seputar diet serta pola hidup sehat</p>

                <a href="@auth /artikel @else /auth?tab=login @endauth"
                    class="inline-block bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition">
                    Lihat Detail →
                </a>
            </div>

        </div>
    </section>


    {{-- CTA SECTION --}}
    @guest
        <section class="bg-green-600 text-white text-center py-16">
            <h2 class="text-3xl font-extrabold mb-3">Siap Memulai Perjalanan Sehat Anda?</h2>
            <p class="text-lg text-green-100 mb-8">Bergabunglah dengan ribuan pengguna lainnya</p>

            <a href="/auth?tab=login"
                class="bg-white text-green-700 px-6 py-3 rounded-lg font-semibold hover:bg-green-100 transition">
                Hitung BMI Sekarang →
            </a>
        </section>
    @endguest


    {{-- FOOTER --}}
    <footer class="text-center py-6 text-gray-500 text-sm bg-white border-t">
        © 2025 FitLife.id — Hidup Sehat Dimulai dari Sekarang
    </footer>

</body>

</html>
