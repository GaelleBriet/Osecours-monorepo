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
            'id' => $this->resource->id,
            'filename' => $this->resource->filename,
            'description' => $this->resource->description,
            'size' => $this->resource->size,
            'url' => $this->resource->url,
            'date' => $this->resource->date,
            'mimetype' => $this->resource->mimetype ? $this->resource->mimetype->name : null,
            'doctype' => $this->resource->doctype ? $this->resource->doctype->name : null,
            'created_at' => $this->resource->created_at,
            'updated_at' => $this->resource->updated_at,
        ];
    }
}
