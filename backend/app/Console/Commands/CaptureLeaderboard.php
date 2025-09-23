<?php

namespace App\Console\Commands;

use App\Services\GamificationService;
use Illuminate\Console\Command;

class CaptureLeaderboard extends Command
{
    protected $signature = 'leaderboard:capture {scope? : Limit capture to a single scope}';

    protected $description = 'Snapshot the current leaderboard standings for caching and analytics.';

    public function handle(GamificationService $service): int
    {
        $scopes = $this->argument('scope')
            ? [$this->argument('scope')]
            : config('gamification.leaderboard_scopes', ['global']);

        foreach ($scopes as $scope) {
            $snapshot = $service->captureSnapshot($scope);
            $this->info(sprintf(
                'Captured %s leaderboard with %d entries at %s',
                $scope,
                count($snapshot->payload ?? []),
                $snapshot->captured_at?->toDateTimeString() ?? now()->toDateTimeString()
            ));
        }

        return self::SUCCESS;
    }
}
