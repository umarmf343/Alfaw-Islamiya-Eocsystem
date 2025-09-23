@extends('layouts.app')

@section('title', 'Create Account')

@section('content')
<section class="mx-auto max-w-2xl px-6 py-16">
    <div class="rounded-[3rem] border border-emerald-100/80 bg-white/80 p-10 shadow-2xl shadow-emerald-100 backdrop-blur">
        <p class="text-xs font-semibold uppercase tracking-[0.3em] text-emerald-500">Start your journey</p>
        <h1 class="mt-3 text-3xl font-bold text-slate-900">Create an AlFawz account</h1>
        <form method="POST" action="{{ route('register') }}" class="mt-8 grid gap-6 md:grid-cols-2">
            @csrf
            <div class="md:col-span-2">
                <label for="name" class="text-sm font-semibold text-slate-700">Full name</label>
                <input id="name" name="name" type="text" value="{{ old('name') }}" required class="mt-2 w-full rounded-2xl border border-emerald-100/80 bg-white/70 px-4 py-3 text-sm text-slate-700 shadow-inner shadow-emerald-50 focus:border-emerald-400 focus:outline-none focus:ring-2 focus:ring-emerald-200" />
            </div>
            <div class="md:col-span-2">
                <label for="email" class="text-sm font-semibold text-slate-700">Email</label>
                <input id="email" name="email" type="email" value="{{ old('email') }}" required class="mt-2 w-full rounded-2xl border border-emerald-100/80 bg-white/70 px-4 py-3 text-sm text-slate-700 shadow-inner shadow-emerald-50 focus:border-emerald-400 focus:outline-none focus:ring-2 focus:ring-emerald-200" />
            </div>
            <div>
                <label for="password" class="text-sm font-semibold text-slate-700">Password</label>
                <input id="password" name="password" type="password" required class="mt-2 w-full rounded-2xl border border-emerald-100/80 bg-white/70 px-4 py-3 text-sm text-slate-700 shadow-inner shadow-emerald-50 focus:border-emerald-400 focus:outline-none focus:ring-2 focus:ring-emerald-200" />
            </div>
            <div>
                <label for="password_confirmation" class="text-sm font-semibold text-slate-700">Confirm password</label>
                <input id="password_confirmation" name="password_confirmation" type="password" required class="mt-2 w-full rounded-2xl border border-emerald-100/80 bg-white/70 px-4 py-3 text-sm text-slate-700 shadow-inner shadow-emerald-50 focus:border-emerald-400 focus:outline-none focus:ring-2 focus:ring-emerald-200" />
            </div>
            <div>
                <label for="role" class="text-sm font-semibold text-slate-700">Role</label>
                <select id="role" name="role" class="mt-2 w-full rounded-2xl border border-emerald-100/80 bg-white/70 px-4 py-3 text-sm text-slate-700 shadow-inner shadow-emerald-50 focus:border-emerald-400 focus:outline-none focus:ring-2 focus:ring-emerald-200">
                    @foreach ($roles as $role)
                        <option value="{{ $role }}" @selected(old('role') === $role)>{{ $role }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="timezone" class="text-sm font-semibold text-slate-700">Timezone</label>
                <input id="timezone" name="timezone" type="text" value="{{ old('timezone', config('app.timezone')) }}" class="mt-2 w-full rounded-2xl border border-emerald-100/80 bg-white/70 px-4 py-3 text-sm text-slate-700 shadow-inner shadow-emerald-50 focus:border-emerald-400 focus:outline-none focus:ring-2 focus:ring-emerald-200" />
            </div>
            <div class="md:col-span-2">
                <button type="submit" class="w-full rounded-full bg-gradient-to-r from-emerald-500 via-emerald-400 to-teal-400 px-6 py-3 text-sm font-semibold text-white shadow-xl shadow-emerald-200 transition hover:-translate-y-1">
                    Create account
                </button>
            </div>
        </form>
        <p class="mt-6 text-center text-sm text-slate-600">
            Already registered? <a href="{{ route('login') }}" class="font-semibold text-emerald-600">Sign in</a>
        </p>
    </div>
</section>
@endsection
