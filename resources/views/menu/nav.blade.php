@php
    use Illuminate\Support\Str;
    use Illuminate\Support\Facades\Storage;
@endphp

{{-- Tambahkan x-init untuk mengecek tema saat pertama kali load --}}
<nav x-data="{
    open: false,
    darkMode: localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches),
    toggleTheme() {
        this.darkMode = !this.darkMode;
        if (this.darkMode) {
            document.documentElement.classList.add('dark');
            localStorage.setItem('theme', 'dark');
        } else {
            document.documentElement.classList.remove('dark');
            localStorage.setItem('theme', 'light');
        }
    }
}" x-init="if (darkMode) document.documentElement.classList.add('dark');
else document.documentElement.classList.remove('dark');"
    class="sticky top-0 z-50 bg-background-base/90 backdrop-blur-md border-b border-card-border">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-20">

            {{-- Logo --}}
            <a href="{{ route('home') }}" class="flex items-center gap-2 text-primary font-bold text-lg">
                <img src="{{ asset('images/logo.png') }}" alt="FitLife Logo" class="w-9 h-9 object-contain">
                <span>FitLife.id</span>
            </a>

            {{-- Desktop Menu --}}
            <div x-data="{ active: '{{ Route::currentRouteName() }}' }" class="hidden md:flex items-center gap-8">
                <a href="{{ route('home') }}" @click="active = 'home'"
                    :class="active === 'home' ? 'text-primary border-b-2 border-primary' :
                        'text-text-muted hover:text-primary'"
                    class="font-medium transition pb-1">Home</a>

                <a href="{{ route('kalkulator') }}" @click="active = 'kalkulator'"
                    :class="active === 'kalkulator' ? 'text-primary border-b-2 border-primary' :
                        'text-text-muted hover:text-primary'"
                    class="font-medium transition pb-1">Kalkulator BMI</a>

                <a href="{{ route('menu') }}" @click="active = 'menu'"
                    :class="active === 'menu' ? 'text-primary border-b-2 border-primary' :
                        'text-text-muted hover:text-primary'"
                    class="font-medium transition pb-1">Menu Sehat</a>

                <a href="{{ route('artikel.index') }}" @click="active = 'artikel.index'"
                    :class="active === 'artikel.index' ? 'text-primary border-b-2 border-primary' :
                        'text-text-muted hover:text-primary'"
                    class="font-medium transition pb-1">Artikel</a>
            </div>

            {{-- Right Section --}}
            <div class="hidden md:flex items-center gap-4">

                {{-- Toggle Dark Mode Button --}}
                <button @click="toggleTheme()"
                    class="p-2 rounded-xl bg-card-border/30 hover:bg-card-border transition text-text-muted">
                    <span class="material-icons-round text-xl" x-show="!darkMode">dark_mode</span>
                    <span class="material-icons-round text-xl text-yellow-400" x-show="darkMode">light_mode</span>
                </button>

                @if (Auth::check())
                    @php
                        $user = Auth::user();
                        $profilePhoto = asset('default-user.png');

                        if (!empty($user->photo)) {
                            $path = $user->photo;
                            $profilePhoto = Storage::url($path);
                        } elseif (!empty($user->google_avatar)) {
                            $profilePhoto = $user->google_avatar;
                        }
                    @endphp

                    {{-- ✅ Avatar --}}
                    <a href="{{ route('test.profile') }}"
                        class="relative w-10 h-10 rounded-full
                   ring-2 ring-primary/40 hover:ring-primary
                   transition duration-300 hover:scale-105">

                        <div class="w-full h-full rounded-full overflow-hidden">
                            <img src="{{ $profilePhoto }}" alt="Profile" class="w-full h-full object-cover">
                        </div>

                        <span
                            class="absolute -bottom-1 -right-1
                       w-3.5 h-3.5 bg-green-400
                       rounded-full ring-2 ring-background-base">
                        </span>
                    </a>
                @else
                    {{-- ✅ Login --}}
                    <a href="{{ route('auth.login') }}"
                        class="bg-primary hover:bg-primary-hover
                   text-background-dark px-6 py-2.5
                   rounded-full font-semibold
                   shadow-[0_0_15px_rgba(0,255,127,0.3)]
                   transition transform hover:-translate-y-0.5">
                        Login
                    </a>
                @endif
            </div>

            {{-- Mobile Menu Button --}}
            <div class="md:hidden flex items-center gap-3">
                {{-- Dark Mode Button Mobile --}}
                <button @click="toggleTheme()" class="p-2 text-text-muted">
                    <span class="material-icons-round text-2xl" x-show="!darkMode">dark_mode</span>
                    <span class="material-icons-round text-2xl text-yellow-400" x-show="darkMode">light_mode</span>
                </button>
                <button @click="open = !open" class="text-text-light hover:text-primary transition">
                    <span class="material-icons-round text-3xl">menu</span>
                </button>
            </div>
        </div>
    </div>

    {{-- Mobile Dropdown --}}
    <div x-show="open" x-transition @click.away="open = false"
        class="md:hidden bg-background-base border-t border-card-border">
        <div class="px-6 py-6 flex flex-col gap-4">
            <a href="{{ route('home') }}" class="text-text-muted hover:text-primary transition">Home</a>
            <a href="{{ route('kalkulator') }}" class="text-text-muted hover:text-primary transition">Kalkulator
                BMI</a>
            <a href="{{ route('menu') }}" class="text-text-muted hover:text-primary transition">Menu Sehat</a>
            <a href="{{ route('artikel.index') }}" class="text-text-muted hover:text-primary transition">Artikel</a>

            @auth
                <a href="{{ route('test.profile') }}" class="text-text-muted hover:text-primary transition">Profile</a>
            @endauth

            @guest
                <a href="{{ route('auth.login') }}"
                    class="mt-4 bg-primary text-background-dark px-4 py-2 rounded-lg font-semibold text-center">
                    Login
                </a>
            @endguest
        </div>
    </div>
</nav>
