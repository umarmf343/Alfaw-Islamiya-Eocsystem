<?php

namespace App\Http\Controllers;

use App\Http\Requests\AssignmentFeedbackRequest;
use App\Http\Requests\AssignmentStoreRequest;
use App\Http\Requests\AssignmentUpdateRequest;
use App\Models\Assignment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AssignmentController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = Assignment::query()
            ->with(['classroom', 'teacher', 'submissions.user'])
            ->orderByDesc('due_date');

        if ($request->user()->hasRole('Teacher')) {
            $query->where('teacher_id', $request->user()->id);
        }

        if ($classroomId = $request->query('classroom_id')) {
            $query->where('classroom_id', $classroomId);
        }

        return response()->json($query->paginate());
    }

    public function store(AssignmentStoreRequest $request): JsonResponse
    {
        $assignment = Assignment::create($request->validated());

        return response()->json($assignment->load('classroom', 'teacher'), 201);
    }

    public function show(Assignment $assignment): JsonResponse
    {
        $this->authorize('view', $assignment);

        return response()->json($assignment->load(['classroom', 'teacher', 'submissions.user']));
    }

    public function update(AssignmentUpdateRequest $request, Assignment $assignment): JsonResponse
    {
        $this->authorize('update', $assignment);

        $assignment->update($request->validated());

        return response()->json($assignment->fresh()->load('classroom', 'teacher'));
    }

    public function destroy(Assignment $assignment): JsonResponse
    {
        $this->authorize('delete', $assignment);

        $assignment->delete();

        return response()->noContent();
    }

    public function feedback(AssignmentFeedbackRequest $request, Assignment $assignment): JsonResponse
    {
        $this->authorize('grade', $assignment);

        $payload = $request->validated();

        $submission = $assignment->submissions()->updateOrCreate(
            ['user_id' => $payload['student_id']],
            [
                'score' => $payload['score'],
                'feedback' => $payload['feedback'] ?? null,
                'audio_feedback_path' => $payload['audio_feedback_path'] ?? null,
            ]
        );

        return response()->json($submission->load('user'));
    }
}
