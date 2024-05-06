<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DocumentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "filename" => $this->filename,
            "description" => $this->description,
            "size" => $this->size,
            "url" => $this->url,
            "date" => $this->date,
            "mimetype" => $this->mimetype ? $this->mimetype->name : null,
            "doctype" => $this->doctype ? $this->doctype->name : null,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
