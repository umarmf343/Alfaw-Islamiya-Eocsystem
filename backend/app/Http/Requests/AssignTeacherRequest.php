<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AssignTeacherRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->hasRole('Admin') ?? false;
    }

    public function rules(): array
    {
        return [
            'teacher_ids' => ['required', 'array'],
            'teacher_ids.*' => ['integer', 'exists:users,id'],
        ];
    }
}
