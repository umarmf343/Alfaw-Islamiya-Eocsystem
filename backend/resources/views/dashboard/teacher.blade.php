@extends('layouts.app')

@section('title', 'Teacher Dashboard')

@section('content')
<section class="mx-auto max-w-6xl px-6 py-16">
    <div class="grid gap-6 lg:grid-cols-3">
        <div class="lg:col-span-2 space-y-8">
            <div class="rounded-[3rem] border border-emerald-100/80 bg-white/80 p-10 shadow-2xl shadow-emerald-100 backdrop-blur">
                <p class="text-xs font-semibold uppercase tracking-[0.3em] text-emerald-500">Assalamu alaikum, {{ $user->name }}</p>
                <h2 class="mt-3 text-3xl font-bold text-slate-900">Classroom health overview</h2>
                <div class="mt-6 grid gap-4 sm:grid-cols-2">
                    @forelse ($classrooms as $classroom)
                        <div class="rounded-3xl border border-emerald-100 bg-white/70 px-6 py-5 shadow-md shadow-emerald-100">
                            <div class="flex items-center justify-between">
                                <p class="text-lg font-semibold text-slate-900">{{ $classroom->name }}</p>
                                <span class="rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700">{{ $classroom->students_count }} learners</span>
                            </div>
                            <p class="mt-2 text-xs text-slate-500">{{ $classroom->description }}</p>
                            <p class="mt-4 text-xs text-emerald-600">{{ $classroom->assignments_count }} active assignments</p>
                        </div>
                    @empty
                        <div class="rounded-3xl border border-dashed border-emerald-200 bg-white/60 px-6 py-10 text-sm text-slate-500">No classrooms assigned yet. Reach out to an administrator to get started.</div>
                    @endforelse
                </div>
            </div>

            <div class="rounded-[2.5rem] border border-emerald-100/70 bg-white/80 p-8 shadow-xl shadow-emerald-100 backdrop-blur">
                <div class="flex items-center justify-between">
                    <h3 class="text-xl font-semibold text-slate-900">Assignments under your care</h3>
                    <a href="#" class="text-sm font-semibold text-emerald-600">Create new →</a>
                </div>
                <div class="mt-5 space-y-4">
                    @forelse ($assignments as $assignment)
                        <div class="rounded-3xl border border-emerald-100 bg-white/70 px-5 py-4 shadow-md shadow-emerald-100">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="font-semibold text-slate-800">{{ $assignment->title }}</p>
                                    <p class="text-xs text-slate-500">{{ $assignment->classroom?->name }} • Due {{ optional($assignment->due_date)->format('d M') }}</p>
                                </div>
                                <span class="text-xs text-emerald-600">{{ $assignment->submissions_count }} submissions</span>
                            </div>
                            <p class="mt-2 text-xs text-slate-500">{{ \Illuminate\Support\Str::limit($assignment->description, 120) }}</p>
                        </div>
                    @empty
                        <p class="rounded-3xl border border-dashed border-emerald-200 bg-white/60 px-5 py-6 text-sm text-slate-500">No assignments created yet.</p>
                    @endforelse
                </div>
            </div>
        </div>
        <aside class="space-y-8">
            <div class="rounded-[2.5rem] border border-emerald-100/80 bg-white/80 p-7 shadow-xl shadow-emerald-100">
                <h3 class="text-lg font-semibold text-slate-900">Recitations awaiting feedback</h3>
                <ul class="mt-5 space-y-3 text-sm text-slate-700">
                    @forelse ($pendingRecitations as $recitation)
                        <li class="rounded-3xl border border-emerald-100 bg-white/70 px-5 py-4 shadow-md shadow-emerald-100">
                            <p class="font-semibold text-slate-800">{{ $recitation->user?->name }}</p>
                            <p class="mt-1 text-xs text-slate-500">{{ $recitation->surah }} • {{ $recitation->ayah_range }}</p>
                            <p class="mt-1 text-xs text-emerald-600">Submitted {{ optional($recitation->created_at)->diffForHumans() }}</p>
                        </li>
                    @empty
                        <li class="rounded-3xl border border-dashed border-emerald-200 bg-white/60 px-5 py-4 text-sm text-slate-500">All recitations reviewed. Barakallahu feek!</li>
                    @endforelse
                </ul>
            </div>
            <div class="rounded-[2.5rem] border border-emerald-100/80 bg-white/80 p-7 shadow-xl shadow-emerald-100">
                <h3 class="text-lg font-semibold text-slate-900">Institute leaderboard</h3>
                <ul class="mt-5 space-y-2 text-sm text-slate-700">
                    @foreach ($leaderboard as $entry)
                        <li class="flex items-center justify-between rounded-2xl bg-emerald-50/80 px-4 py-3">
                            <span>#{{ $entry['rank'] ?? $loop->iteration }} {{ $entry['name'] ?? 'Anonymous' }}</span>
                            <span class="text-xs text-emerald-600">{{ number_format((float) ($entry['score'] ?? 0), 1) }} pts</span>
                        </li>
                    @endforeach
                </ul>
            </div>
        </aside>
    </div>
</section>
@endsection
