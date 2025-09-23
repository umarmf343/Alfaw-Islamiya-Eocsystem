<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\Classroom;
use App\Models\Payment;
use App\Models\Recitation;
use App\Models\User;
use App\Services\GamificationService;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct(private GamificationService $gamificationService)
    {
    }

    public function __invoke(Request $request): View
    {
        $user = $request->user()->loadMissing(['classrooms', 'recitations']);

        if ($user->hasRole('Admin')) {
            return $this->adminDashboard($user);
        }

        if ($user->hasRole('Teacher')) {
            return $this->teacherDashboard($user);
        }

        return $this->studentDashboard($user);
    }

    protected function studentDashboard($user): View
    {
        $assignments = Assignment::query()
            ->whereIn('classroom_id', $user->classrooms->pluck('id'))
            ->whereDate('due_date', '>=', now()->toDateString())
            ->orderBy('due_date')
            ->limit(5)
            ->get();

        $recentRecitations = $user->recitations()
            ->latest()
            ->limit(5)
            ->get();

        $streaks = $this->gamificationService->streakSummary($user);
        $badges = $this->gamificationService->badges($user);
        $leaderboard = $this->gamificationService->leaderboard('global');

        return view('dashboard.student', compact('user', 'assignments', 'recentRecitations', 'streaks', 'badges', 'leaderboard'));
    }

    protected function teacherDashboard($user): View
    {
        $classrooms = Classroom::query()
            ->withCount(['students', 'assignments'])
            ->whereHas('teachers', fn ($query) => $query->where('users.id', $user->id))
            ->get();

        $pendingRecitations = Recitation::query()
            ->whereNull('score')
            ->where('status', 'completed')
            ->whereHas('assignment', fn ($query) => $query->where('teacher_id', $user->id))
            ->latest()
            ->limit(5)
            ->get();

        $assignments = Assignment::query()
            ->where('teacher_id', $user->id)
            ->withCount('submissions')
            ->orderByDesc('due_date')
            ->limit(5)
            ->get();

        $leaderboard = $this->gamificationService->leaderboard('global');

        return view('dashboard.teacher', compact('user', 'classrooms', 'pendingRecitations', 'assignments', 'leaderboard'));
    }

    protected function adminDashboard($user): View
    {
        $metrics = [
            'students' => $this->countForRole('Student'),
            'teachers' => $this->countForRole('Teacher'),
            'classrooms' => Classroom::count(),
            'monthlyRevenue' => Payment::query()
                ->where('status', 'successful')
                ->where('created_at', '>=', Carbon::now()->startOfMonth())
                ->sum('amount'),
        ];

        $recentPayments = Payment::query()
            ->with('user')
            ->latest()
            ->limit(5)
            ->get();

        $leaderboard = $this->gamificationService->leaderboard('global');

        return view('dashboard.admin', compact('user', 'metrics', 'recentPayments', 'leaderboard'));
    }

    protected function countForRole(string $role): int
    {
        return cache()->remember("metrics:role:{$role}", now()->addMinutes(10), fn () => User::role($role)->count());
    }
}
