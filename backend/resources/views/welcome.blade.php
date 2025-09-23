@extends('layouts.app')

@section('title', "Learn, Recite & Thrive")

@section('content')
<section class="relative overflow-hidden">
    <div class="mx-auto flex max-w-6xl flex-col gap-12 px-6 py-16 lg:flex-row lg:items-center">
        <div class="max-w-xl">
            <div class="inline-flex items-center gap-2 rounded-full border border-emerald-200/70 bg-white/70 px-4 py-2 text-xs font-semibold uppercase tracking-[0.3em] text-emerald-600 shadow-lg shadow-emerald-100">
                Harmonise your memorisation journey
            </div>
            <h1 class="mt-6 text-4xl font-black tracking-tight text-slate-900 sm:text-5xl">
                A sanctuary for Qur'an recitation, habit building, and soulful progress.
            </h1>
            <p class="mt-6 text-lg text-slate-600">
                AlFawz unites students, teachers, and administrators in a single Laravel-powered experience with AI recitation feedback, adaptive memorisation reviews, and joyful community leaderboards.
            </p>
            <div class="mt-8 flex flex-wrap gap-4">
                <a href="{{ route('register') }}" class="inline-flex items-center gap-3 rounded-full bg-gradient-to-r from-emerald-500 via-emerald-400 to-teal-400 px-6 py-3 text-lg font-semibold text-white shadow-xl shadow-emerald-200 transition hover:-translate-y-1">
                    Begin your hifdh plan
                    <span class="inline-flex h-7 w-7 items-center justify-center rounded-full bg-white/20 text-sm">↗</span>
                </a>
                <a href="#community" class="inline-flex items-center gap-2 rounded-full border border-emerald-200/80 bg-white/70 px-5 py-3 text-sm font-semibold text-emerald-600 transition hover:-translate-y-1 hover:bg-emerald-50/80">
                    Explore community feedback
                </a>
            </div>
            <dl class="mt-12 grid gap-6 sm:grid-cols-3">
                <div class="rounded-2xl border border-emerald-100 bg-white/70 px-5 py-4 shadow-md shadow-emerald-100">
                    <dt class="text-xs font-semibold uppercase tracking-[0.3em] text-emerald-500">Daily recitations</dt>
                    <dd class="mt-3 text-3xl font-bold text-slate-900">2.4k</dd>
                    <dd class="text-xs text-slate-500">processed seamlessly each week</dd>
                </div>
                <div class="rounded-2xl border border-emerald-100 bg-white/70 px-5 py-4 shadow-md shadow-emerald-100">
                    <dt class="text-xs font-semibold uppercase tracking-[0.3em] text-emerald-500">Active streaks</dt>
                    <dd class="mt-3 text-3xl font-bold text-slate-900">87</dd>
                    <dd class="text-xs text-slate-500">students on 30-day journeys</dd>
                </div>
                <div class="rounded-2xl border border-emerald-100 bg-white/70 px-5 py-4 shadow-md shadow-emerald-100">
                    <dt class="text-xs font-semibold uppercase tracking-[0.3em] text-emerald-500">Teacher feedback</dt>
                    <dd class="mt-3 text-3xl font-bold text-slate-900">1.2k</dd>
                    <dd class="text-xs text-slate-500">insights shared monthly</dd>
                </div>
            </dl>
        </div>
        <div class="relative mx-auto max-w-xl">
            <div class="absolute -left-10 -top-10 h-72 w-72 animate-pulse-slow rounded-full bg-gradient-to-br from-emerald-200 via-emerald-100 to-transparent blur-3xl"></div>
            <div class="absolute -right-10 bottom-12 h-52 w-52 animate-pulse-slow rounded-full bg-gradient-to-br from-amber-200 via-amber-100 to-transparent blur-3xl"></div>
            <div class="relative rounded-3xl border border-white/60 bg-white/80 p-6 shadow-2xl shadow-emerald-100 backdrop-blur">
                <p class="text-sm font-semibold uppercase tracking-[0.3em] text-emerald-500">Live leaderboard</p>
                <ul class="mt-4 space-y-3">
                    @forelse ($leaderboard as $entry)
                        <li class="flex items-center justify-between rounded-2xl bg-emerald-50/70 px-4 py-3 text-sm font-medium text-emerald-700">
                            <div class="flex items-center gap-3">
                                <span class="inline-flex h-9 w-9 items-center justify-center rounded-2xl bg-white text-base font-semibold text-emerald-600 shadow shadow-emerald-100">{{ $entry['rank'] ?? $loop->iteration }}</span>
                                <div>
                                    <p class="font-semibold">{{ $entry['name'] ?? 'Anonymous' }}</p>
                                    <p class="text-xs text-emerald-500">{{ number_format((float) ($entry['score'] ?? 0), 1) }} Hasanat</p>
                                </div>
                            </div>
                            <span class="text-xs text-emerald-600/70">🌙</span>
                        </li>
                    @empty
                        <li class="rounded-2xl bg-white/70 px-4 py-3 text-sm text-slate-500">No recitations have been ranked yet. Be the first to submit!</li>
                    @endforelse
                </ul>
                <p class="mt-6 text-xs text-slate-500">Snapshots refresh hourly from our gamification service.</p>
            </div>
        </div>
    </div>
</section>

<section id="features" class="mx-auto max-w-6xl px-6 pb-16">
    <div class="rounded-[3rem] border border-emerald-100/70 bg-white/80 p-10 shadow-xl shadow-emerald-100 backdrop-blur">
        <h2 class="text-center text-3xl font-bold text-slate-900">Crafted to balance excellence and ease</h2>
        <p class="mx-auto mt-4 max-w-2xl text-center text-base text-slate-600">
            Every module is purpose-built for Qur'an academies: from AI assisted recitation checks to admin-level oversight.
        </p>
        <div class="mt-10 grid gap-6 md:grid-cols-2">
            @foreach ($features as $feature)
                <div class="rounded-3xl border border-emerald-100 bg-gradient-to-br from-white via-emerald-50/50 to-white px-6 py-8 shadow-lg shadow-emerald-100">
                    <h3 class="text-lg font-semibold text-emerald-700">{{ $feature }}</h3>
                    <p class="mt-3 text-sm text-slate-600">We wrap complex workflows into calm, elegant dashboards so that your teachers can focus on mentorship.</p>
                </div>
            @endforeach
        </div>
    </div>
</section>

<section id="community" class="mx-auto max-w-6xl px-6 pb-16">
    <div class="grid gap-8 lg:grid-cols-2">
        <div class="rounded-3xl border border-emerald-100/80 bg-white/80 p-8 shadow-xl shadow-emerald-100">
            <p class="text-xs font-semibold uppercase tracking-[0.3em] text-emerald-500">Testimonials</p>
            <blockquote class="mt-4 text-lg font-medium text-slate-700">
                “Our students adore the recitation journey screen. Hearing Whisper-backed feedback within minutes keeps them motivated, and the streak dashboards remind them of Allah's blessings.”
            </blockquote>
            <div class="mt-6 flex items-center gap-3">
                <div class="h-12 w-12 rounded-full bg-gradient-to-tr from-emerald-200 to-emerald-400"></div>
                <div>
                    <p class="text-sm font-semibold text-slate-800">Ustadh Kareem</p>
                    <p class="text-xs text-slate-500">Lead Teacher, Darul Ilm</p>
                </div>
            </div>
        </div>
        <div class="rounded-3xl border border-emerald-100/80 bg-white/80 p-8 shadow-xl shadow-emerald-100">
            <p class="text-xs font-semibold uppercase tracking-[0.3em] text-emerald-500">Admin Insights</p>
            <p class="mt-4 text-sm text-slate-600">
                Monitor payments, enrolments, and class health from the Laravel dashboard. Queue workers process recitations asynchronously while scheduled jobs refresh leaderboards for all campuses.
            </p>
            <ul class="mt-6 space-y-2 text-sm text-slate-600">
                <li>• Robust permissions via Spatie Roles &amp; Permissions</li>
                <li>• Queue-backed Whisper transcription with Hasanat ledgering</li>
                <li>• Paystack webhooks that unlock classrooms automatically</li>
            </ul>
        </div>
    </div>
</section>

<section id="pricing" class="mx-auto max-w-6xl px-6 pb-24">
    <div class="grid gap-8 md:grid-cols-3">
        <div class="rounded-3xl border border-slate-200/80 bg-white/70 p-8 shadow-lg">
            <p class="text-xs font-semibold uppercase tracking-[0.3em] text-slate-500">Starter</p>
            <p class="mt-5 text-4xl font-bold text-slate-900">Free</p>
            <p class="mt-2 text-sm text-slate-600">Ideal for families or small halaqahs exploring digital memorisation.</p>
            <ul class="mt-6 space-y-2 text-sm text-slate-600">
                <li>• 5 student accounts</li>
                <li>• Weekly leaderboard snapshots</li>
                <li>• Guided memorisation cards</li>
            </ul>
        </div>
        <div class="relative overflow-hidden rounded-3xl border border-emerald-200 bg-gradient-to-br from-emerald-500 via-emerald-400 to-teal-400 p-[1px] shadow-emerald-200">
            <div class="h-full rounded-[calc(1.5rem-1px)] bg-white/90 p-8 text-emerald-700">
                <p class="text-xs font-semibold uppercase tracking-[0.3em] text-emerald-500">Academy</p>
                <p class="mt-5 text-4xl font-bold text-emerald-700">₦15,000<span class="text-base font-medium text-emerald-600">/month</span></p>
                <p class="mt-2 text-sm text-emerald-600">Perfect for institutes managing multiple classrooms and teachers.</p>
                <ul class="mt-6 space-y-2 text-sm text-emerald-600">
                    <li>• Unlimited student profiles</li>
                    <li>• Paystack enrolment automation</li>
                    <li>• Real-time streak and Hasanat analytics</li>
                </ul>
                <a href="{{ route('register') }}" class="mt-8 inline-flex items-center gap-3 rounded-full bg-emerald-500 px-5 py-3 text-sm font-semibold text-white shadow-lg shadow-emerald-300 transition hover:-translate-y-1">
                    Upgrade your institute
                    <span class="inline-flex h-7 w-7 items-center justify-center rounded-full bg-white/20 text-sm">★</span>
                </a>
            </div>
        </div>
        <div class="rounded-3xl border border-slate-200/80 bg-white/70 p-8 shadow-lg">
            <p class="text-xs font-semibold uppercase tracking-[0.3em] text-slate-500">Enterprise</p>
            <p class="mt-5 text-4xl font-bold text-slate-900">Let's talk</p>
            <p class="mt-2 text-sm text-slate-600">Tailored onboarding, SSO, and white-labelled experiences for large organisations.</p>
            <ul class="mt-6 space-y-2 text-sm text-slate-600">
                <li>• Dedicated success manager</li>
                <li>• Private leaderboards &amp; analytics exports</li>
                <li>• Priority support with SLA</li>
            </ul>
        </div>
    </div>
</section>
@endsection
