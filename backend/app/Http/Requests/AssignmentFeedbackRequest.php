<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AssignmentFeedbackRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->hasRole('Teacher') || $this->user()?->hasRole('Admin');
    }

    public function rules(): array
    {
        return [
            'student_id' => ['required', 'integer', 'exists:users,id'],
            'score' => ['required', 'numeric', 'between:0,100'],
            'feedback' => ['nullable', 'string'],
            'audio_feedback_path' => ['nullable', 'string'],
        ];
    }
}
