<?php 

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AnimalResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'birth_date' => $this->birth_date,
            'cats_friendly' => $this->cats_friendly,
            'dogs_friendly' => $this->dogs_friendly,
            'children_friendly' => $this->children_friendly,
            'age' => $this->age,
            'behavioral_comment' => $this->behavioral_comment,
            'sterilized' => $this->sterilized,
            'deceased' => $this->deceased,
            'bread' => $this->breed ? $this->breed->name : null,
            'specie' => $this->specie ? $this->specie->name : null,
            'gender' => $this->gender ? $this->gender->name : null,
            'color' => $this->color ? $this->color->name : null,
            'coat' => $this->coat ? $this->coat->name : null,
            'sizerange' => $this->sizeRange ? $this->sizeRange->name : null,
            'agerange' => $this->agerange ? $this->agerange->name : null,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,
        ];
    }
}
