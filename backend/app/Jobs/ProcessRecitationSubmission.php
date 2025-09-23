<?php

namespace App\Jobs;

use App\Models\Recitation;
use App\Services\HasanatService;
use App\Services\RecitationFeedbackService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ProcessRecitationSubmission implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(private int $recitationId)
    {
    }

    public function handle(RecitationFeedbackService $feedbackService, HasanatService $hasanatService): void
    {
        $recitation = Recitation::query()->find($this->recitationId);

        if (! $recitation) {
            return;
        }

        try {
            $audioPath = Storage::disk('public')->path($recitation->audio_path);

            $feedback = $feedbackService->transcribeAndScore($audioPath, $recitation->expected_text);
            $hasanat = $hasanatService->calculateForText($recitation->expected_text);

            $recitation->update([
                'feedback' => $feedback,
                'score' => $feedback['score'] ?? null,
                'hasanat' => $hasanat,
                'status' => 'completed',
            ]);

            $hasanatService->record($recitation, $hasanat, 'recitation_submission');
        } catch (\Throwable $exception) {
            Log::error('Failed to process recitation submission', [
                'recitation_id' => $this->recitationId,
                'message' => $exception->getMessage(),
            ]);

            $recitation->update([
                'status' => 'failed',
            ]);
        }
    }
}
