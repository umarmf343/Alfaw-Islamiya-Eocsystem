<?php

namespace App\Services;

use App\Models\DailyHabit;
use App\Models\LeaderboardSnapshot;
use App\Models\User;
use Illuminate\Support\Collection;

class GamificationService
{
    public function leaderboard(string $scope): array
    {
        $snapshot = LeaderboardSnapshot::query()
            ->where('scope', $scope)
            ->latest('captured_at')
            ->first();

        if ($snapshot) {
            return $snapshot->payload;
        }

        return $this->generateLeaderboard($scope)->toArray();
    }

    public function streakSummary(User $user): array
    {
        $habits = DailyHabit::query()
            ->where('user_id', $user->id)
            ->orderByDesc('date')
            ->limit(30)
            ->get()
            ->sortBy('date')
            ->values();

        $currentStreak = 0;
        $longestStreak = 0;
        $previousDate = null;

        foreach ($habits as $habit) {
            if (! $habit->completed) {
                $currentStreak = 0;
                $previousDate = null;
                continue;
            }

            if ($previousDate === null) {
                $currentStreak = 1;
            } elseif ($habit->date->diffInDays($previousDate, true) == 1) {
                $currentStreak++;
            } else {
                $currentStreak = 1;
            }

            $longestStreak = max($longestStreak, $currentStreak);
            $previousDate = $habit->date;
        }

        return [
            'current' => $currentStreak,
            'longest' => $longestStreak,
        ];
    }

    public function badges(User $user): array
    {
        return $user->badges()
            ->with('badge')
            ->get()
            ->map(fn ($award) => [
                'name' => $award->badge->name,
                'awarded_at' => $award->awarded_at,
            ])->toArray();
    }

    protected function generateLeaderboard(string $scope): Collection
    {
        return User::query()
            ->withSum('recitations as total_score', 'score')
            ->orderByDesc('total_score')
            ->limit(10)
            ->get()
            ->map(fn (User $user, int $index) => [
                'rank' => $index + 1,
                'name' => $user->name,
                'score' => (float) $user->total_score,
            ]);
    }
}
