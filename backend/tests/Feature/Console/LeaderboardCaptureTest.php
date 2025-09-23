<?php

namespace Tests\Feature\Console;

use App\Models\Recitation;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LeaderboardCaptureTest extends TestCase
{
    use RefreshDatabase;

    protected bool $seed = true;

    public function test_command_creates_leaderboard_snapshot(): void
    {
        $user = User::factory()->create(['name' => 'Student One']);
        $user->assignRole('Student');

        Recitation::create([
            'user_id' => $user->id,
            'surah' => 'Al-Fatihah',
            'ayah_range' => '1-7',
            'audio_path' => 'recitations/dummy.mp3',
            'expected_text' => 'بِسْمِ اللّٰهِ الرَّحْمٰنِ الرَّحِيْمِ',
            'feedback' => ['score' => 95],
            'score' => 95,
            'hasanat' => 700,
            'status' => 'completed',
        ]);

        $this->artisan('leaderboard:capture')
            ->expectsOutputToContain('Captured global leaderboard')
            ->assertExitCode(0);

        $this->assertDatabaseHas('leaderboard_snapshots', [
            'scope' => 'global',
        ]);
    }
}
