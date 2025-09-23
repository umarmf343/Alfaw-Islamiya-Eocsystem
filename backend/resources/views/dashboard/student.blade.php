@extends('layouts.app')

@section('title', 'Student Dashboard')

@section('content')
<section class="mx-auto max-w-6xl px-6 py-16">
    <div class="flex flex-col gap-6 lg:flex-row">
        <div class="w-full lg:w-2/3">
            <div class="rounded-[3rem] border border-emerald-100/80 bg-white/80 p-10 shadow-2xl shadow-emerald-100 backdrop-blur">
                <p class="text-xs font-semibold uppercase tracking-[0.3em] text-emerald-500">Salaam, {{ $user->name }}</p>
                <h2 class="mt-3 text-3xl font-bold text-slate-900">Your memorisation pulse</h2>
                <p class="mt-2 text-sm text-slate-600">Keep your streak alive and submit your next recitation to climb the leaderboard.</p>
                <div class="mt-8 grid gap-4 sm:grid-cols-3">
                    <div class="rounded-3xl border border-emerald-100 bg-white/70 p-5 shadow-md shadow-emerald-100">
                        <p class="text-xs font-semibold uppercase tracking-[0.3em] text-emerald-500">Current streak</p>
                        <p class="mt-2 text-3xl font-bold text-slate-900">{{ $streaks['current'] }}</p>
                        <p class="text-xs text-slate-500">days in a row</p>
                    </div>
                    <div class="rounded-3xl border border-emerald-100 bg-white/70 p-5 shadow-md shadow-emerald-100">
                        <p class="text-xs font-semibold uppercase tracking-[0.3em] text-emerald-500">Longest streak</p>
                        <p class="mt-2 text-3xl font-bold text-slate-900">{{ $streaks['longest'] }}</p>
                        <p class="text-xs text-slate-500">historical best</p>
                    </div>
                    <div class="rounded-3xl border border-emerald-100 bg-white/70 p-5 shadow-md shadow-emerald-100">
                        <p class="text-xs font-semibold uppercase tracking-[0.3em] text-emerald-500">Badges earned</p>
                        <p class="mt-2 text-3xl font-bold text-slate-900">{{ count($badges) }}</p>
                        <p class="text-xs text-slate-500">milestones unlocked</p>
                    </div>
                </div>
            </div>

            <div class="mt-8 rounded-[2.5rem] border border-emerald-100/70 bg-white/80 p-8 shadow-xl shadow-emerald-100 backdrop-blur">
                <div class="flex items-center justify-between">
                    <h3 class="text-xl font-semibold text-slate-900">Upcoming assignments</h3>
                    <a href="#" class="text-sm font-semibold text-emerald-600">View calendar →</a>
                </div>
                <div class="mt-6 space-y-4">
                    @forelse ($assignments as $assignment)
                        <div class="flex items-center justify-between rounded-3xl border border-emerald-100 bg-white/70 px-5 py-4 shadow-md shadow-emerald-100">
                            <div>
                                <p class="font-semibold text-slate-800">{{ $assignment->title }}</p>
                                <p class="text-xs text-slate-500">{{ $assignment->classroom?->name }} • Due {{ optional($assignment->due_date)->format('d M') }}</p>
                            </div>
                            <span class="rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700">{{ $assignment->due_date?->diffForHumans() ?? 'Scheduled' }}</span>
                        </div>
                    @empty
                        <p class="rounded-3xl border border-dashed border-emerald-200 bg-white/60 px-5 py-6 text-sm text-slate-500">No assignments due. Use this time to review previous surahs.</p>
                    @endforelse
                </div>
            </div>
        </div>
        <aside class="w-full space-y-8 lg:w-1/3">
            <div class="rounded-[2.5rem] border border-emerald-100/80 bg-white/80 p-7 shadow-xl shadow-emerald-100">
                <h3 class="text-lg font-semibold text-slate-900">Recent recitations</h3>
                <ul class="mt-5 space-y-3">
                    @forelse ($recentRecitations as $recitation)
                        <li class="rounded-3xl border border-emerald-100 bg-white/70 px-5 py-4 text-sm text-slate-700 shadow-md shadow-emerald-100">
                            <div class="flex items-center justify-between">
                                <p class="font-semibold">{{ $recitation->surah }} • {{ $recitation->ayah_range }}</p>
                                <span class="text-xs text-emerald-600">{{ ucfirst($recitation->status ?? 'pending') }}</span>
                            </div>
                            <p class="mt-2 text-xs text-slate-500">Score: {{ $recitation->score ? number_format($recitation->score, 1) : 'Processing' }}</p>
                        </li>
                    @empty
                        <li class="rounded-3xl border border-dashed border-emerald-200 bg-white/60 px-5 py-4 text-sm text-slate-500">Submit your first recitation to see AI-powered feedback here.</li>
                    @endforelse
                </ul>
            </div>
            <div class="rounded-[2.5rem] border border-emerald-100/80 bg-white/80 p-7 shadow-xl shadow-emerald-100">
                <h3 class="text-lg font-semibold text-slate-900">Top performers</h3>
                <ul class="mt-5 space-y-2 text-sm text-slate-700">
                    @foreach ($leaderboard as $entry)
                        <li class="flex items-center justify-between rounded-2xl bg-emerald-50/80 px-4 py-3">
                            <span class="font-medium">#{{ $entry['rank'] ?? $loop->iteration }} {{ $entry['name'] ?? 'Anonymous' }}</span>
                            <span class="text-xs text-emerald-600">{{ number_format((float) ($entry['score'] ?? 0), 1) }} pts</span>
                        </li>
                    @endforeach
                </ul>
            </div>
        </aside>
    </div>
</section>
@endsection
