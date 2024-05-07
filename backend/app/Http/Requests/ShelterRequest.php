<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ShelterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'string|max:100|required',
            'description' => 'string|nullable',
            'email' => 'email|nullable',
            'phone' => 'nullable|max:10|min:10|string',
            'siret' => 'nullable|max:14|min:14|string'
        ];
    }
}
