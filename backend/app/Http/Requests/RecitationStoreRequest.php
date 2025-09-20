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
            'audio_path' => ['required', 'string'],
            'expected_text' => ['required', 'string'],
        ];
    }
}
