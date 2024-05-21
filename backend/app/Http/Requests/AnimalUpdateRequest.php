<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AnimalUpdateRequest extends FormRequest
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
            'name' => 'string|max:100|nullable',
            'description' => 'string|nullable',
            'birth_date' => 'date|nullable',
            'cats_friendly' => 'boolean|nullable',
            'dogs_friendly' => 'boolean|nullable',
            'children_friendly' => 'boolean|nullable',
            'age' => 'integer|nullable',
            'behavioral_comment' => 'string|nullable',
            'sterilized' => 'boolean|nullable',
            'deceased' => 'boolean',
            'specie_id' => 'nullable|exists:species,id',
            'gender_id' => 'nullable|exists:genders,id',
            'color_id' => 'nullable|exists:colors,id',
            'coat_id' => 'nullable|exists:coats,id',
            'sizerange_id' => 'nullable|exists:size_ranges,id',
            'agerange_id' => 'nullable|exists:age_ranges,id',
            'breed_id' => 'nullable|exists:breeds,id',
            'number' => 'nullable|max:15|string'
        ];
    }
}
