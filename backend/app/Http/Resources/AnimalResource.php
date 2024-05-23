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
            'breed_id' => $this->breed_id,
            'specie_id' => $this->specie_id,
            'gender_id' => $this->gender_id,
            'color_id' => $this->color_id,
            'coat_id' => $this->coat_id,
            'sizerange_id' => $this->sizerange_id,
            'agerange_id' => $this->agerange_id,   
            'identification' => $this->identification,
            'vaccines' => VaccineResource::collection($this->vaccines),         
            'breed' => $this->breed ? ["name"=> $this->breed->name, "id" => $this->breed->id]: null,
            'specie' => $this->specie ? ["name"=> $this->specie->name, "id" => $this->specie->id]: null,
            'gender' => $this->gender ? ["name"=> $this->gender->name, "id" => $this->gender->id]: null,
            'color' => $this->color ? ["name"=> $this->color->name, "id" => $this->color->id]: null,
            'coat' => $this->coart ? ["name"=> $this->coart->name, "id" => $this->coart->id]: null,
            'sizerange' => $this->SizeRange ? ["name"=> $this->SizeRange->name, "id" => $this->SizeRange->id]: null,
            'agerange' => $this->AgeRange ? ["name"=> $this->AgeRange->name, "id" => $this->AgeRange->id]: null,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,
        ];
    }
}
