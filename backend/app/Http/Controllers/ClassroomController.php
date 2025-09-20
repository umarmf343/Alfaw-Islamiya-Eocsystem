<?php

namespace App\Http\Controllers;

use App\Http\Requests\AssignTeacherRequest;
use App\Http\Requests\ClassroomStoreRequest;
use App\Http\Requests\ClassroomUpdateRequest;
use App\Http\Requests\EnrollStudentRequest;
use App\Models\Classroom;
use Illuminate\Http\JsonResponse;

class ClassroomController extends Controller
{
    public function index(): JsonResponse
    {
        $classrooms = Classroom::query()
            ->with(['teachers', 'students'])
            ->orderBy('name')
            ->paginate();

        return response()->json($classrooms);
    }

    public function store(ClassroomStoreRequest $request): JsonResponse
    {
        $classroom = Classroom::create($request->validated());

        return response()->json($classroom, 201);
    }

    public function show(Classroom $classroom): JsonResponse
    {
        $this->authorize('view', $classroom);

        return response()->json($classroom->load(['teachers', 'students', 'assignments']));
    }

    public function update(ClassroomUpdateRequest $request, Classroom $classroom): JsonResponse
    {
        $this->authorize('update', $classroom);

        $classroom->update($request->validated());

        return response()->json($classroom);
    }

    public function destroy(Classroom $classroom): JsonResponse
    {
        $this->authorize('update', $classroom);

        $classroom->delete();

        return response()->noContent();
    }

    public function assignTeacher(AssignTeacherRequest $request, Classroom $classroom): JsonResponse
    {
        $classroom->teachers()->syncWithoutDetaching($request->validated('teacher_ids'));

        return response()->json($classroom->load('teachers'));
    }

    public function enrollStudent(EnrollStudentRequest $request, Classroom $classroom): JsonResponse
    {
        $classroom->enrollments()->updateOrCreate(
            ['student_id' => $request->validated('student_id')],
            ['status' => 'active']
        );

        return response()->json($classroom->load('students'));
    }
}
