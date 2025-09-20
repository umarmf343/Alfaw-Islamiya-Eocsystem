<?php

namespace App\Http\Controllers;

use App\Http\Requests\MemorizationReviewCompleteRequest;
use App\Http\Requests\MemorizationReviewStoreRequest;
use App\Models\MemorizationReview;
use App\Services\SpacedRepetitionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MemorizationReviewController extends Controller
{
    public function __construct(private SpacedRepetitionService $spacedRepetitionService)
    {
    }

    public function index(Request $request): JsonResponse
    {
        $reviews = $this->spacedRepetitionService->pendingReviews($request->user());

        return response()->json($reviews);
    }

    public function store(MemorizationReviewStoreRequest $request): JsonResponse
    {
        $review = MemorizationReview::create(array_merge(
            $request->validated(),
            ['user_id' => $request->user()->id]
        ));

        return response()->json($review, 201);
    }

    public function complete(MemorizationReviewCompleteRequest $request, MemorizationReview $review): JsonResponse
    {
        $this->authorize('update', $review);

        $updated = $this->spacedRepetitionService->completeReview($review, $request->validated('quality'));

        return response()->json($updated);
    }
}
