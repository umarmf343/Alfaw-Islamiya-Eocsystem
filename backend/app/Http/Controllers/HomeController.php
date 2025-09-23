<?php

namespace App\Http\Controllers;

use App\Services\GamificationService;
use Illuminate\Contracts\View\View;

class HomeController extends Controller
{
    public function __invoke(GamificationService $gamificationService): View
    {
        $leaderboard = $gamificationService->leaderboard('global');

        return view('welcome', [
            'leaderboard' => array_slice($leaderboard, 0, 5),
            'features' => [
                'Adaptive memorisation reviews using SM-2 scheduling',
                'AI-assisted feedback powered by Whisper and Hasanat tracking',
                'Classroom collaboration spaces for teachers and students',
                'Gamified streaks, badges, and community leaderboards',
            ],
        ]);
    }
}
