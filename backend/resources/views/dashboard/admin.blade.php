@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<section class="mx-auto max-w-6xl px-6 py-16">
    <div class="grid gap-8 lg:grid-cols-3">
        <div class="lg:col-span-2 space-y-8">
            <div class="rounded-[3rem] border border-emerald-100/80 bg-white/80 p-10 shadow-2xl shadow-emerald-100 backdrop-blur">
                <p class="text-xs font-semibold uppercase tracking-[0.3em] text-emerald-500">Admin overview</p>
                <h2 class="mt-3 text-3xl font-bold text-slate-900">Operational insights</h2>
                <div class="mt-8 grid gap-6 sm:grid-cols-2">
                    <div class="rounded-3xl border border-emerald-100 bg-white/70 px-6 py-5 shadow-md shadow-emerald-100">
                        <p class="text-xs font-semibold uppercase tracking-[0.3em] text-emerald-500">Students</p>
                        <p class="mt-3 text-4xl font-bold text-slate-900">{{ number_format($metrics['students']) }}</p>
                        <p class="text-xs text-slate-500">active learners across campuses</p>
                    </div>
                    <div class="rounded-3xl border border-emerald-100 bg-white/70 px-6 py-5 shadow-md shadow-emerald-100">
                        <p class="text-xs font-semibold uppercase tracking-[0.3em] text-emerald-500">Teachers</p>
                        <p class="mt-3 text-4xl font-bold text-slate-900">{{ number_format($metrics['teachers']) }}</p>
                        <p class="text-xs text-slate-500">mentors guiding the journey</p>
                    </div>
                    <div class="rounded-3xl border border-emerald-100 bg-white/70 px-6 py-5 shadow-md shadow-emerald-100">
                        <p class="text-xs font-semibold uppercase tracking-[0.3em] text-emerald-500">Classrooms</p>
                        <p class="mt-3 text-4xl font-bold text-slate-900">{{ number_format($metrics['classrooms']) }}</p>
                        <p class="text-xs text-slate-500">active halaqahs</p>
                    </div>
                    <div class="rounded-3xl border border-emerald-100 bg-white/70 px-6 py-5 shadow-md shadow-emerald-100">
                        <p class="text-xs font-semibold uppercase tracking-[0.3em] text-emerald-500">Monthly revenue</p>
                        <p class="mt-3 text-4xl font-bold text-slate-900">₦{{ number_format($metrics['monthlyRevenue'], 2) }}</p>
                        <p class="text-xs text-slate-500">Paystack confirmed receipts</p>
                    </div>
                </div>
            </div>

            <div class="rounded-[2.5rem] border border-emerald-100/80 bg-white/80 p-8 shadow-xl shadow-emerald-100 backdrop-blur">
                <div class="flex items-center justify-between">
                    <h3 class="text-xl font-semibold text-slate-900">Recent payments</h3>
                    <a href="#" class="text-sm font-semibold text-emerald-600">Export CSV →</a>
                </div>
                <div class="mt-5 space-y-4">
                    @forelse ($recentPayments as $payment)
                        <div class="rounded-3xl border border-emerald-100 bg-white/70 px-5 py-4 shadow-md shadow-emerald-100">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="font-semibold text-slate-800">{{ $payment->user?->name }}</p>
                                    <p class="text-xs text-slate-500">Reference: {{ $payment->reference }}</p>
                                </div>
                                <span class="text-sm font-semibold text-emerald-600">₦{{ number_format($payment->amount, 2) }}</span>
                            </div>
                            <p class="mt-2 text-xs text-slate-500">{{ ucfirst($payment->status) }} • {{ optional($payment->created_at)->diffForHumans() }}</p>
                        </div>
                    @empty
                        <p class="rounded-3xl border border-dashed border-emerald-200 bg-white/60 px-5 py-6 text-sm text-slate-500">No payments recorded yet.</p>
                    @endforelse
                </div>
            </div>
        </div>
        <aside class="space-y-8">
            <div class="rounded-[2.5rem] border border-emerald-100/80 bg-white/80 p-7 shadow-xl shadow-emerald-100">
                <h3 class="text-lg font-semibold text-slate-900">Global leaderboard</h3>
                <ul class="mt-5 space-y-2 text-sm text-slate-700">
                    @foreach ($leaderboard as $entry)
                        <li class="flex items-center justify-between rounded-2xl bg-emerald-50/80 px-4 py-3">
                            <span>#{{ $entry['rank'] ?? $loop->iteration }} {{ $entry['name'] ?? 'Anonymous' }}</span>
                            <span class="text-xs text-emerald-600">{{ number_format((float) ($entry['score'] ?? 0), 1) }} pts</span>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="rounded-[2.5rem] border border-emerald-100/80 bg-white/80 p-7 shadow-xl shadow-emerald-100">
                <h3 class="text-lg font-semibold text-slate-900">Operational playbook</h3>
                <ul class="mt-4 space-y-2 text-sm text-slate-600">
                    <li>• Keep <code class="rounded bg-emerald-50 px-1 py-0.5">queue:work</code> running for recitation jobs</li>
                    <li>• Ensure <code class="rounded bg-emerald-50 px-1 py-0.5">leaderboard:capture</code> is scheduled hourly</li>
                    <li>• Configure Paystack webhooks with signature secret for automated enrolments</li>
                </ul>
            </div>
        </aside>
    </div>
</section>
@endsection
