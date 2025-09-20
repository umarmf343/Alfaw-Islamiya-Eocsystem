<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class RecitationFeedbackService
{
    public function transcribeAndScore(string $audioPath, string $expectedText): array
    {
        $stream = is_file($audioPath) ? fopen($audioPath, 'r') : null;

        $request = Http::withToken(config('services.openai.key'));

        if ($stream) {
            $request = $request->attach('file', $stream, basename($audioPath));
        } else {
            $request = $request->attach('file', $audioPath, basename($audioPath));
        }

        $response = $request
            ->post('https://api.openai.com/v1/audio/transcriptions', [
                'model' => config('services.openai.whisper_model', 'whisper-1'),
            ])->throw()->json();

        if ($stream) {
            fclose($stream);
        }

        $transcript = $response['text'] ?? '';
        $score = $this->calculateSimilarityScore($expectedText, $transcript);

        return [
            'transcript' => $transcript,
            'score' => $score,
            'notes' => $this->generateNotes($expectedText, $transcript),
        ];
    }

    protected function calculateSimilarityScore(string $expected, string $actual): float
    {
        similar_text(mb_strtolower($expected), mb_strtolower($actual), $percent);

        return round($percent, 2);
    }

    protected function generateNotes(string $expected, string $actual): array
    {
        return [
            'missing_words' => array_values(array_diff(
                preg_split('/\s+/u', trim($expected)),
                preg_split('/\s+/u', trim($actual))
            )),
        ];
    }
}
