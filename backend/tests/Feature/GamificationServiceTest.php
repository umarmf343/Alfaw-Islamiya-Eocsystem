<?php

namespace Tests\Feature;

use App\Models\DailyHabit;
use App\Models\User;
use App\Services\GamificationService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class GamificationServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_streak_summary_resets_current_streak_after_missed_day(): void
    {
        $user = User::factory()->create();
        $service = new GamificationService();
        $today = Carbon::today();

        DailyHabit::create([
            'user_id' => $user->id,
            'date' => $today,
            'completed' => true,
        ]);

        DailyHabit::create([
            'user_id' => $user->id,
            'date' => $today->copy()->subDay(),
            'completed' => false,
        ]);

        DailyHabit::create([
            'user_id' => $user->id,
            'date' => $today->copy()->subDays(2),
            'completed' => true,
        ]);

        DailyHabit::create([
            'user_id' => $user->id,
            'date' => $today->copy()->subDays(3),
            'completed' => true,
        ]);

        $summary = $service->streakSummary($user);

        $this->assertSame(1, $summary['current']);
        $this->assertSame(2, $summary['longest']);
    }
}
