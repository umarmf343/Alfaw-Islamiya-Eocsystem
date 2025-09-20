<?php

namespace App\Services;

use App\Models\MemorizationReview;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class SpacedRepetitionService
{
    public function pendingReviews(User $user): Collection
    {
        return MemorizationReview::query()
            ->where('user_id', $user->id)
            ->whereDate('scheduled_for', '<=', Carbon::today())
            ->orderBy('scheduled_for')
            ->get();
    }

    public function completeReview(MemorizationReview $review, int $quality): MemorizationReview
    {
        $easeFactor = max(1.3, ($review->ease_factor ?? 2.5) + (0.1 - (5 - $quality) * (0.08 + (5 - $quality) * 0.02)));
        $repetitions = ($review->repetitions ?? 0) + 1;
        $interval = $this->nextInterval($repetitions, $quality, $review->interval ?? 1, $easeFactor);

        $review->update([
            'ease_factor' => $easeFactor,
            'repetitions' => $repetitions,
            'interval' => $interval,
            'last_reviewed_at' => Carbon::now(),
            'scheduled_for' => Carbon::now()->addDays($interval),
        ]);

        return $review;
    }

    protected function nextInterval(int $repetitions, int $quality, int $currentInterval, float $easeFactor): int
    {
        if ($quality < 3) {
            return 1;
        }

        return match ($repetitions) {
            1 => 1,
            2 => 6,
            default => (int) round($currentInterval * $easeFactor),
        };
    }
}
