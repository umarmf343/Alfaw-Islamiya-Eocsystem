<?php

namespace App\Http\Controllers;

use App\Http\Requests\RecitationScoreRequest;
use App\Http\Requests\RecitationStoreRequest;
use App\Jobs\ProcessRecitationSubmission;
use App\Models\Recitation;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RecitationController extends Controller
{

    public function index(Request $request): JsonResponse
    {
        $recitations = Recitation::query()
            ->where('user_id', $request->user()->id)
            ->latest()
            ->paginate();

        return response()->json($recitations);
    }

    public function store(RecitationStoreRequest $request): JsonResponse
    {
        $payload = $request->validated();

        $storedPath = $request->file('audio')->store(
            'recitations/' . $request->user()->id,
            'public'
        );

        $recitation = Recitation::create([
            'user_id' => $request->user()->id,
            'assignment_id' => $payload['assignment_id'] ?? null,
            'surah' => $payload['surah'],
            'ayah_range' => $payload['ayah_range'],
            'audio_path' => $storedPath,
            'expected_text' => $payload['expected_text'],
            'status' => 'processing',
        ]);

        ProcessRecitationSubmission::dispatch($recitation->id);

        return response()->json([
            'recitation' => $recitation->fresh(),
            'message' => 'Recitation received. Feedback will be available once processing completes.',
        ], 202);
    }

    public function score(RecitationScoreRequest $request, Recitation $recitation): JsonResponse
    {
        $this->authorize('update', $recitation);

        $recitation->update($request->validated());

        return response()->json($recitation);
    }
}
