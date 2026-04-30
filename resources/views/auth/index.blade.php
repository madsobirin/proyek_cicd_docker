<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login & Daftar | FitLife</title>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="{{ asset('images/logo.png') }}">
</head>

<body class="bg-green-50 flex items-center justify-center min-h-screen">

    <div x-data="{ tab: new URLSearchParams(window.location.search).get('tab') || 'login' }" class="bg-white shadow-md rounded-2xl p-8 w-96 overflow-hidden">
        <h2 class="text-center text-2xl font-bold mb-1 text-green-700">Selamat Datang di FitLife</h2>
        <p class="text-center text-gray-500 mb-4">Masuk atau daftar untuk melanjutkan</p>

        <!-- Tab switch -->
        <div class="flex mb-4 bg-gray-100 rounded-lg p-1">
            <button :class="tab === 'login' ? 'bg-white shadow font-semibold text-green-700' : 'text-gray-500'"
                @click="tab = 'login'" class="flex-1 rounded-lg py-2 transition-all">
                Login
            </button>
            <button :class="tab === 'register' ? 'bg-white shadow font-semibold text-green-700' : 'text-gray-500'"
                @click="tab = 'register'" class="flex-1 rounded-lg py-2 transition-all">
                Daftar
            </button>
        </div>

        <!-- Login Form -->
        <template x-if="tab === 'login'">
            <div x-transition>
                <form action="{{ route('auth.login') }}" method="POST">
                    @csrf
                    <label>Username</label>
                    <input type="text" name="username" class="w-full border rounded-lg p-2 mb-3"
                        placeholder="Username" required>

                    <label>Password</label>
                    <input type="password" name="password" class="w-full border rounded-lg p-2 mb-3"
                        placeholder="Password" required>

                    <button type="submit"
                        class="w-full bg-green-600 text-white py-2 rounded-lg hover:bg-green-700 transition">
                        Login
                    </button>
                </form>

                <!-- Divider -->
                <div class="my-4 flex items-center">
                    <div class="flex-grow h-px bg-gray-300"></div>
                    <span class="text-gray-400 text-sm px-2">atau</span>
                    <div class="flex-grow h-px bg-gray-300"></div>
                </div>

                <!-- Google Login Button -->
                <a href="{{ route('auth.google.redirect') }}"
                    class="w-full flex items-center justify-center gap-3 border border-gray-300 py-2 rounded-lg hover:bg-gray-100 transition">
                    <img src="https://www.gstatic.com/firebasejs/ui/2.0.0/images/auth/google.svg" class="w-5 h-5"
                        alt="Google Logo">
                    <span class="text-gray-700 font-medium">Masuk dengan Google</span>
                </a>
            </div>
        </template>

        <!-- Register Form -->
        <template x-if="tab === 'register'">
            <div x-transition>
                <form action="{{ route('auth.register') }}" method="POST">
                    @csrf
                    <label>Nama Lengkap</label>
                    <input type="text" name="nama_lengkap" class="w-full border rounded-lg p-2 mb-3"
                        placeholder="Nama Lengkap" required>

                    <label>Email</label>
                    <input type="email" name="email" class="w-full border rounded-lg p-2 mb-3" placeholder="Email"
                        required>

                    <label>Password</label>
                    <input type="password" name="password" class="w-full border rounded-lg p-2 mb-3"
                        placeholder="Password" required>

                    <button type="submit"
                        class="w-full bg-green-600 text-white py-2 rounded-lg hover:bg-green-700 transition">
                        Daftar
                    </button>
                </form>

                <!-- Divider -->
                <div class="my-4 flex items-center">
                    <div class="flex-grow h-px bg-gray-300"></div>
                    <span class="text-gray-400 text-sm px-2">atau</span>
                    <div class="flex-grow h-px bg-gray-300"></div>
                </div>

                <!-- Google Login Button -->
                <a href="{{ route('auth.google.redirect') }}"
                    class="w-full flex items-center justify-center gap-3 border border-gray-300 py-2 rounded-lg hover:bg-gray-100 transition">
                    <img src="https://www.gstatic.com/firebasejs/ui/2.0.0/images/auth/google.svg" class="w-5 h-5"
                        alt="Google Logo">
                    <span class="text-gray-700 font-medium">Daftar dengan Google</span>
                </a>
            </div>
        </template>

        <!-- Alert Messages -->
        @if (session('success'))
            <div class="mt-4 text-green-600 text-sm text-center">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="mt-4 text-red-600 text-sm text-center">{{ session('error') }}</div>
        @endif

        <div class="text-center mt-6">
            <a href="/" class="text-green-600 text-sm hover:underline">← Kembali ke Beranda</a>
        </div>
    </div>

</body>

</html>
