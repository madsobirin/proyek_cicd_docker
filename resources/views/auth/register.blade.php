<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>FitLife - Join the Elite</title>
    <link href="https://fonts.googleapis.com" rel="preconnect" />
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;900&display=swap"
        rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap"
        rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body
    class="bg-background-base text-text-light min-h-screen flex flex-col font-display overflow-x-hidden transition-colors duration-300">

    <header class="absolute top-0 left-0 w-full z-20 px-6 py-6 md:px-12 flex items-center justify-between">
        <a href="/" class="flex items-center gap-3 group">
            <div class="size-8 text-primary group-hover:scale-110 transition-transform">
                <svg class="w-full h-full" fill="none" viewbox="0 0 48 48" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M13.8261 30.5736C16.7203 29.8826 20.2244 29.4783 24 29.4783C27.7756 29.4783 31.2797 29.8826 34.1739 30.5736C36.9144 31.2278 39.9967 32.7669 41.3563 33.8352L24.8486 7.36089C24.4571 6.73303 23.5429 6.73303 23.1514 7.36089L6.64374 33.8352C8.00331 32.7669 11.0856 31.2278 13.8261 30.5736Z"
                        fill="currentColor"></path>
                    <path clip-rule="evenodd"
                        d="M39.998 35.764C39.9944 35.7463 39.9875 35.7155 39.9748 35.6706C39.9436 35.5601 39.8949 35.4259 39.8346 35.2825C39.8168 35.2403 39.7989 35.1993 39.7813 35.1602C38.5103 34.2887 35.9788 33.0607 33.7095 32.5189C30.9875 31.8691 27.6413 31.4783 24 31.4783C20.3587 31.4783 17.0125 31.8691 14.2905 32.5189C12.0012 33.0654 9.44505 34.3104 8.18538 35.1832C8.17384 35.2075 8.16216 35.233 8.15052 35.2592C8.09919 35.3751 8.05721 35.4886 8.02977 35.589C8.00356 35.6848 8.00039 35.7333 8.00004 35.7388C8.00004 35.739 8 35.7393 8.00004 35.7388C8.00004 35.7641 8.0104 36.0767 8.68485 36.6314C9.34546 37.1746 10.4222 37.7531 11.9291 38.2772C14.9242 39.319 19.1919 40 24 40C28.8081 40 33.0758 39.319 36.0709 38.2772C37.5778 37.7531 38.6545 37.1746 39.3151 36.6314C39.9006 36.1499 39.9857 35.8511 39.998 35.764ZM4.95178 32.7688L21.4543 6.30267C22.6288 4.4191 25.3712 4.41909 26.5457 6.30267L43.0534 32.777C43.0709 32.8052 43.0878 32.8338 43.104 32.8629L41.3563 33.8352C43.104 32.8629 43.1038 32.8626 43.104 32.8629L43.1051 32.865L43.1065 32.8675L43.1101 32.8739L43.1199 32.8918C43.1276 32.906 43.1377 32.9246 43.1497 32.9473C43.1738 32.9925 43.2062 33.0545 43.244 33.1299C43.319 33.2792 43.4196 33.489 43.5217 33.7317C43.6901 34.1321 44 34.9311 44 35.7391C44 37.4427 43.003 38.7775 41.8558 39.7209C40.6947 40.6757 39.1354 41.4464 37.385 42.0552C33.8654 43.2794 29.133 44 24 44C18.867 44 14.1346 43.2794 10.615 42.0552C8.86463 41.4464 7.30529 40.6757 6.14419 39.7209C4.99695 38.7775 3.99999 37.4427 3.99999 35.7391C3.99999 34.8725 4.29264 34.0922 4.49321 33.6393C4.60375 33.3898 4.71348 33.1804 4.79687 33.0311C4.83898 32.9556 4.87547 32.8935 4.9035 32.8471C4.91754 32.8238 4.92954 32.8043 4.93916 32.7889L4.94662 32.777L4.95178 32.7688ZM35.9868 29.004L24 9.77997L12.0131 29.004C12.4661 28.8609 12.9179 28.7342 13.3617 28.6282C16.4281 27.8961 20.0901 27.4783 24 27.4783C27.9099 27.4783 31.5719 27.8961 34.6383 28.6282C35.082 28.7342 35.5339 28.8609 35.9868 29.004Z"
                        fill="currentColor" fill-rule="evenodd"></path>
                </svg>
            </div>
            <span class="font-bold text-xl tracking-tight text-text-light">FitLife</span>
        </a>
        <div class="hidden md:block">
            <span class="text-sm text-text-muted font-medium mr-2">Already a member?</span>
            <a class="text-sm font-bold text-primary hover:underline transition-all"
                href="{{ route('auth.login') }}">Sign In</a>
        </div>
    </header>

    <div class="flex flex-1 w-full min-h-screen">

        <div class="hidden lg:flex w-[45%] xl:w-[50%] relative items-center justify-center p-8 lg:p-16 overflow-hidden">
            <div
                class="absolute inset-0 bg-primary/5 dark:bg-primary/10 z-0 skew-x-[-5deg] origin-top-left -ml-20 w-[120%] transition-colors duration-500">
            </div>

            <div class="relative z-10 w-full h-full flex flex-col justify-center">
                <div class="aspect-square relative w-full max-w-150 mx-auto group">
                    {{-- Glow Effect --}}
                    <div
                        class="absolute inset-0 bg-primary/20 blur-[100px] rounded-full opacity-0 dark:opacity-100 transition-opacity duration-500">
                    </div>
                    <img alt="Dumbbell"
                        class="w-full h-full object-contain drop-shadow-2xl group-hover:scale-105 transition-transform duration-700 ease-in-out relative z-10"
                        src="https://lh3.googleusercontent.com/aida-public/AB6AXuAdccM75rveHr9ewK4pM05KoXqbLcOf-7-y0tTTtA5TyOVNzvHCY87s8prAeDcLtNaEmt4e9-_tmnJ2GofwsDCrM9IHNbUU38MNNEnqIO05SROslJjGHiiYarHRtiRcW1rA2P2x7Ou_ywE0SDY2gfKUA-9Qv8-1R8rQ06YwsCwsNYmdRcQBZJ6KjWPkLMh-2GSb1kpPYIv69X1M37bgxv-Tbozy1w6qRsf6oXgrGYapiV9YMczDqnxbcCWbg9KsTqsWVqI0h7J29OY" />
                </div>
                <div class="mt-8 max-w-md mx-auto text-center lg:text-left">
                    <div class="flex items-center gap-2 mb-4 justify-center lg:justify-start">
                        <span class="material-symbols-outlined text-primary text-3xl">bolt</span>
                        <span class="uppercase tracking-widest text-xs font-bold text-text-muted">Elite
                            Performance</span>
                    </div>
                    <h2 class="text-3xl xl:text-5xl font-black tracking-tighter leading-tight text-text-light">
                        Unlock your potential.<br />
                        <span class="text-primary">Join the evolution.</span>
                    </h2>
                </div>
            </div>
        </div>

        <div
            class="w-full lg:w-[55%] xl:w-[50%] flex flex-col justify-center items-center p-6 sm:p-12 lg:p-20 bg-background-base z-10 transition-colors duration-300 mt-20 md:mt-0">
            <div class="w-full max-w-md space-y-8 animate-fade-in-up">

                <div class="space-y-2 text-center lg:text-left">
                    <h1 class="text-4xl font-black tracking-tighter text-text-light">Start Your Journey</h1>
                    <p class="text-text-muted text-base font-normal">
                        Create your account to access elite tracking and coaching.
                    </p>
                </div>

                <form class="space-y-5" action="{{ route('auth.register.post') }}" method="POST">
                    @csrf

                    <div class="group">
                        <label class="block text-sm font-semibold text-text-muted mb-1.5 ml-1">Full Name</label>
                        <div class="relative">
                            <input
                                class="w-full h-14 bg-card-dark dark:bg-background-dark rounded-xl border-0 ring-1 ring-card-border focus:ring-2 focus:ring-primary transition-all duration-200 pl-4 pr-4 placeholder:text-text-muted/50 text-base font-medium text-text-light shadow-sm"
                                placeholder="Enter your full name" type="text" name="username" required />
                        </div>
                    </div>

                    <div class="group">
                        <label class="block text-sm font-semibold text-text-muted mb-1.5 ml-1">Email Address</label>
                        <div class="relative">
                            <input
                                class="w-full h-14 bg-card-dark dark:bg-background-dark rounded-xl border-0 ring-1 ring-card-border focus:ring-2 focus:ring-primary transition-all duration-200 pl-4 pr-4 placeholder:text-text-muted/50 text-base font-medium text-text-light shadow-sm"
                                placeholder="name@example.com" type="email" name="email" required />
                        </div>
                    </div>

                    <div class="group">
                        <label class="block text-sm font-semibold text-text-muted mb-1.5 ml-1">Password</label>
                        <div class="relative">
                            <input
                                class="w-full h-14 bg-card-dark dark:bg-background-dark rounded-xl border-0 ring-1 ring-card-border focus:ring-2 focus:ring-primary transition-all duration-200 pl-4 pr-12 placeholder:text-text-muted/50 text-base font-medium text-text-light shadow-sm"
                                placeholder="Create a secure password" type="password" name="password" required />
                            <button
                                class="absolute right-4 top-1/2 -translate-y-1/2 text-text-muted hover:text-primary transition-colors"
                                type="button">
                                <span class="material-symbols-outlined text-xl">visibility</span>
                            </button>
                        </div>
                    </div>

                    <button
                        class="w-full h-14 bg-primary hover:bg-primary-hover text-background-base font-bold cursor-pointer text-base rounded-xl shadow-glow hover:shadow-lg hover:-translate-y-0.5 active:translate-y-0 transition-all duration-200 flex items-center justify-center gap-2 mt-4">
                        <span>Create Account</span>
                        <span class="material-symbols-outlined text-lg">arrow_forward</span>
                    </button>
                </form>

                <div class="relative py-2">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-card-border"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="bg-background-base px-4 text-text-muted font-medium italic">or join with</span>
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-4">
                    <a href="{{ route('auth.google.redirect') }}"
                        class="flex items-center justify-center gap-3 h-14 rounded-xl bg-card-dark border border-card-border hover:border-primary transition-all duration-200 group">
                        <svg class="w-5 h-5" viewBox="0 0 24 24">
                            <path
                                d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"
                                fill="#4285F4"></path>
                            <path
                                d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"
                                fill="#34A853"></path>
                            <path
                                d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"
                                fill="#FBBC05"></path>
                            <path
                                d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"
                                fill="#EA4335"></path>
                        </svg>
                        <span class="text-sm font-bold text-text-light">Continue with Google</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
