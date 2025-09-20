<?php

namespace App\Http\Controllers;

use App\Http\Requests\HabitCheckInRequest;
use App\Models\DailyHabit;
use App\Services\GamificationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GamificationController extends Controller
{
    public function __construct(private GamificationService $gamificationService)
    {
    }

    public function leaderboard(Request $request): JsonResponse
    {
        $scope = $request->query('scope', 'global');

        return response()->json($this->gamificationService->leaderboard($scope));
    }

    public function streaks(Request $request): JsonResponse
    {
        return response()->json($this->gamificationService->streakSummary($request->user()));
    }

    public function badges(Request $request): JsonResponse
    {
        return response()->json($this->gamificationService->badges($request->user()));
    }

    public function checkIn(HabitCheckInRequest $request): JsonResponse
    {
        $habit = DailyHabit::updateOrCreate(
            [
                'user_id' => $request->user()->id,
                'date' => now()->toDateString(),
            ],
            [
                'completed' => true,
                'notes' => $request->validated('notes'),
            ]
        );

        $summary = $this->gamificationService->streakSummary($request->user());

        return response()->json([
            'habit' => $habit,
            'streaks' => $summary,
        ]);
    }
}
