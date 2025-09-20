<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RecitationScoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->hasRole('Teacher') || $this->user()?->hasRole('Admin');
    }

    public function rules(): array
    {
        return [
            'score' => ['required', 'numeric', 'between:0,100'],
            'feedback' => ['nullable', 'string'],
            'hasanat' => ['nullable', 'integer', 'min:0'],
        ];
    }
}
