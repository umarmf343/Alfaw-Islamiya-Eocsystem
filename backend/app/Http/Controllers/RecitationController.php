<?php

namespace App\Http\Controllers;

use App\Http\Requests\RecitationScoreRequest;
use App\Http\Requests\RecitationStoreRequest;
use App\Models\Recitation;
use App\Services\HasanatService;
use App\Services\RecitationFeedbackService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RecitationController extends Controller
{
    public function __construct(
        private RecitationFeedbackService $feedbackService,
        private HasanatService $hasanatService
    ) {
    }

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
        $data = array_merge(
            $request->validated(),
            ['user_id' => $request->user()->id]
        );

        $feedback = $this->feedbackService->transcribeAndScore($data['audio_path'], $data['expected_text']);
        $hasanat = $this->hasanatService->calculateForText($data['expected_text']);

        $recitation = Recitation::create(array_merge($data, [
            'feedback' => $feedback,
            'hasanat' => $hasanat,
        ]));

        $ledger = $this->hasanatService->record($recitation, $hasanat, 'recitation_submission');

        return response()->json([
            'recitation' => $recitation,
            'feedback' => $feedback,
            'hasanat_entry' => $ledger,
        ], 201);
    }

    public function score(RecitationScoreRequest $request, Recitation $recitation): JsonResponse
    {
        $this->authorize('update', $recitation);

        $recitation->update($request->validated());

        return response()->json($recitation);
    }
}
