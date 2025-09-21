<?php

namespace App\Services;

use App\Models\HasanatLedger;
use App\Models\Recitation;

class HasanatService
{
    public function calculateForText(string $arabicText): int
    {
        $letters = preg_match_all('/\p{Arabic}/u', $arabicText, $matches);

        return max(0, (int) $letters) * 10;
    }

    public function record(Recitation $recitation, int $points, ?string $reason = null): HasanatLedger
    {
        return HasanatLedger::create([
            'user_id' => $recitation->user_id,
            'recitation_id' => $recitation->id,
            'points' => $points,
            'reason' => $reason,
        ]);
    }
}
