<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AssociationRequest extends FormRequest
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
            'siret' => 'max:14|min:14|string',
            'rib' => 'nullable|string|max:34',
        ];
    }
}
