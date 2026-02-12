<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PdfRenderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'html' => ['required', 'string'],
            'mode' => ['required', 'string', Rule::in(['sync', 'async'])],
            'callback_url' => ['required_if:mode,async', 'nullable', 'url', 'max:2048'],
        ];
    }
}
