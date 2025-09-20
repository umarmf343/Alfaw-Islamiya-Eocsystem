<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MemorizationReviewCompleteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    public function rules(): array
    {
        return [
            'quality' => ['required', 'integer', 'between:0,5'],
        ];
    }
}
