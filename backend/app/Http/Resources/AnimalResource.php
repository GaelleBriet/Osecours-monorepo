<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AnimalResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->resource->id,
            'name' => $this->resource->name,
            'description' => $this->resource->description,
            'birth_date' => $this->resource->birth_date,
            'cats_friendly' => $this->resource->cats_friendly,
            'dogs_friendly' => $this->resource->dogs_friendly,
            'children_friendly' => $this->resource->children_friendly,
            'age' => $this->resource->age,
            'behavioral_comment' => $this->resource->behavioral_comment,
            'sterilized' => $this->resource->sterilized,
            'deceased' => $this->resource->deceased,
            'breed_id' => $this->resource->breed_id,
            'specie_id' => $this->resource->specie_id,
            'gender_id' => $this->resource->gender_id,
            'color_id' => $this->resource->color_id,
            'coat_id' => $this->resource->coat_id,
            'sizerange_id' => $this->resource->sizerange_id,
            'agerange_id' => $this->resource->agerange_id,
            'identification' => $this->resource->identification,
            'vaccines' => VaccineResource::collection($this->resource->vaccines),
            'healthcares' => HealthcareResource::collection($this->resource->healthcares),
            'breed' => $this->resource->breed ? ['name' => $this->resource->breed->name, 'id' => $this->resource->breed->id] : null,
            'specie' => $this->resource->specie ? ['name' => $this->resource->specie->name, 'id' => $this->resource->specie->id] : null,
            'gender' => $this->resource->gender ? ['name' => $this->resource->gender->name, 'id' => $this->resource->gender->id] : null,
            'color' => $this->resource->color ? ['name' => $this->resource->color->name, 'id' => $this->resource->color->id] : null,
            'coat' => $this->resource->coart ? ['name' => $this->resource->coart->name, 'id' => $this->resource->coart->id] : null,
            'sizerange' => $this->resource->SizeRange ? ['name' => $this->resource->SizeRange->name, 'id' => $this->resource->SizeRange->id] : null,
            'agerange' => $this->resource->AgeRange ? ['name' => $this->resource->AgeRange->name, 'id' => $this->resource->AgeRange->id] : null,
            'created_at' => $this->resource->created_at,
            'updated_at' => $this->resource->updated_at,
            'deleted_at' => $this->resource->deleted_at,
        ];
    }
}
