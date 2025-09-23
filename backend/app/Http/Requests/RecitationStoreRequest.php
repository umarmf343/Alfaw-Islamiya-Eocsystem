<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RecitationStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    public function rules(): array
    {
        return [
            'surah' => ['required', 'string'],
            'ayah_range' => ['required', 'string'],
            'audio' => ['required', 'file', 'mimetypes:audio/mpeg,audio/wav,audio/mp4,audio/x-m4a', 'max:25600'],
            'expected_text' => ['required', 'string'],
            'assignment_id' => ['nullable', 'integer', 'exists:assignments,id'],
        ];
    }
}
