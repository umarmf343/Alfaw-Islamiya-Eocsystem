<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="AlFawz Qur'an Institute learning ecosystem">
        <title>@hasSection('title')@yield('title') · @endifAlFawz Qur'an Institute</title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Vela+Sans:wght@600&display=swap" rel="stylesheet">
        @vite(['resources/js/app.js'])
    </head>
    <body class="min-h-screen bg-gradient-to-br from-amber-50 via-white to-emerald-50 text-slate-800">
        <div class="relative">
            <div class="pointer-events-none absolute inset-x-0 top-0 h-96 bg-[radial-gradient(circle_at_top,_rgba(251,191,36,0.35),_transparent_70%)] blur-2xl"></div>
            <div class="pointer-events-none absolute inset-y-0 right-0 hidden w-1/3 bg-[radial-gradient(circle_at_center,_rgba(34,197,94,0.25),_transparent_70%)] blur-3xl lg:block"></div>
        </div>
        <header class="relative z-10">
            <nav class="mx-auto flex max-w-6xl items-center justify-between px-6 py-6">
                <a href="{{ route('home') }}" class="group flex items-center gap-3">
                    <span class="inline-flex h-12 w-12 items-center justify-center rounded-2xl bg-gradient-to-br from-emerald-400 via-emerald-500 to-teal-500 text-white shadow-lg shadow-emerald-200 transition-transform duration-300 group-hover:rotate-6">
                        <svg class="h-7 w-7" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M12 3l7 4v4c0 5-3 9-7 10-4-1-7-5-7-10V7l7-4z" />
                            <path d="M9 10l3 2 3-2" />
                        </svg>
                    </span>
                    <div>
                        <p class="font-display text-lg font-semibold text-emerald-700">AlFawz Institute</p>
                        <p class="text-xs font-medium uppercase tracking-[0.3em] text-emerald-500">Memorise with serenity</p>
                    </div>
                </a>
                <div class="flex items-center gap-4 text-sm font-semibold">
                    <a href="{{ route('home') }}#features" class="rounded-full px-4 py-2 text-slate-600 transition hover:text-emerald-600">Features</a>
                    <a href="{{ route('home') }}#community" class="rounded-full px-4 py-2 text-slate-600 transition hover:text-emerald-600">Community</a>
                    <a href="{{ route('home') }}#pricing" class="rounded-full px-4 py-2 text-slate-600 transition hover:text-emerald-600">Pricing</a>
                    @auth
                        <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 rounded-full bg-emerald-500 px-5 py-2 text-white shadow-lg shadow-emerald-200 transition hover:bg-emerald-600">
                            <span>Dashboard</span>
                        </a>
                        <form method="POST" action="{{ route('logout') }}" class="hidden md:block">
                            @csrf
                            <button type="submit" class="inline-flex items-center gap-2 rounded-full border border-transparent px-4 py-2 text-sm text-emerald-600 transition hover:border-emerald-300 hover:bg-emerald-50">
                                Logout
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="rounded-full px-4 py-2 text-slate-600 transition hover:text-emerald-600">Sign in</a>
                        <a href="{{ route('register') }}" class="inline-flex items-center gap-2 rounded-full bg-emerald-500 px-5 py-2 text-white shadow-lg shadow-emerald-200 transition hover:bg-emerald-600">
                            Join Now
                            <span class="inline-flex h-6 w-6 items-center justify-center rounded-full bg-white/20 text-xs">★</span>
                        </a>
                    @endauth
                </div>
            </nav>
        </header>

        <main class="relative z-10">
            @if(session('status'))
                <div class="mx-auto mb-6 max-w-3xl rounded-2xl border border-emerald-100 bg-emerald-50/80 px-6 py-4 text-sm text-emerald-800 shadow-lg shadow-emerald-100">
                    {{ session('status') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mx-auto mb-6 max-w-3xl rounded-2xl border border-rose-100 bg-rose-50/90 px-6 py-4 text-sm text-rose-700 shadow-lg shadow-rose-100">
                    <p class="mb-2 font-semibold">Please review the highlighted fields:</p>
                    <ul class="list-disc space-y-1 pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')
        </main>

        <footer class="relative z-10 mt-24 bg-white/80 backdrop-blur">
            <div class="mx-auto max-w-6xl px-6 py-10">
                <div class="grid gap-8 md:grid-cols-3">
                    <div>
                        <p class="font-display text-lg font-semibold text-emerald-700">Stay anchored</p>
                        <p class="mt-2 text-sm text-slate-600">Daily recitations, guided memorisation, and meaningful analytics designed for the modern madrasa.</p>
                    </div>
                    <div>
                        <p class="text-sm font-semibold uppercase tracking-[0.3em] text-emerald-500">Contact</p>
                        <p class="mt-2 text-sm text-slate-600">support@alfawz.app</p>
                        <p class="mt-1 text-sm text-slate-600">+234 800 000 0000</p>
                    </div>
                    <div>
                        <p class="text-sm font-semibold uppercase tracking-[0.3em] text-emerald-500">Follow</p>
                        <div class="mt-3 flex gap-3 text-slate-500">
                            <a class="rounded-full bg-emerald-50 p-2 transition hover:-translate-y-1 hover:text-emerald-600" href="#">Twitter</a>
                            <a class="rounded-full bg-emerald-50 p-2 transition hover:-translate-y-1 hover:text-emerald-600" href="#">Instagram</a>
                            <a class="rounded-full bg-emerald-50 p-2 transition hover:-translate-y-1 hover:text-emerald-600" href="#">YouTube</a>
                        </div>
                    </div>
                </div>
                <p class="mt-8 text-center text-xs text-slate-500">© {{ date('Y') }} AlFawz Qur'an Institute. All rights reserved.</p>
            </div>
        </footer>
    </body>
</html>
