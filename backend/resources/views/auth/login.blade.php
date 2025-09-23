@extends('layouts.app')

@section('title', 'Sign In')

@section('content')
<section class="mx-auto max-w-md px-6 py-16">
    <div class="rounded-[2.75rem] border border-emerald-100/80 bg-white/80 p-10 shadow-2xl shadow-emerald-100 backdrop-blur">
        <p class="text-xs font-semibold uppercase tracking-[0.3em] text-emerald-500">Welcome back</p>
        <h1 class="mt-3 text-3xl font-bold text-slate-900">Sign in to continue</h1>
        <form method="POST" action="{{ route('login') }}" class="mt-8 space-y-6">
            @csrf
            <div>
                <label for="email" class="text-sm font-semibold text-slate-700">Email address</label>
                <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus class="mt-2 w-full rounded-2xl border border-emerald-100/80 bg-white/70 px-4 py-3 text-sm text-slate-700 shadow-inner shadow-emerald-50 focus:border-emerald-400 focus:outline-none focus:ring-2 focus:ring-emerald-200" />
            </div>
            <div>
                <label for="password" class="text-sm font-semibold text-slate-700">Password</label>
                <input id="password" name="password" type="password" required class="mt-2 w-full rounded-2xl border border-emerald-100/80 bg-white/70 px-4 py-3 text-sm text-slate-700 shadow-inner shadow-emerald-50 focus:border-emerald-400 focus:outline-none focus:ring-2 focus:ring-emerald-200" />
            </div>
            <div class="flex items-center justify-between text-sm text-slate-600">
                <label class="inline-flex items-center gap-2">
                    <input type="checkbox" name="remember" class="rounded border-emerald-200 text-emerald-600 focus:ring-emerald-400" />
                    Remember me
                </label>
                <a href="#" class="font-semibold text-emerald-600">Forgot password?</a>
            </div>
            <button type="submit" class="w-full rounded-full bg-gradient-to-r from-emerald-500 via-emerald-400 to-teal-400 px-6 py-3 text-sm font-semibold text-white shadow-xl shadow-emerald-200 transition hover:-translate-y-1">
                Enter dashboard
            </button>
        </form>
        <p class="mt-6 text-center text-sm text-slate-600">
            New to AlFawz? <a href="{{ route('register') }}" class="font-semibold text-emerald-600">Create an account</a>
        </p>
    </div>
</section>
@endsection
