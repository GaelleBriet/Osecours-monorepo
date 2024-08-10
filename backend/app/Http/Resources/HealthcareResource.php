<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class HealthcareResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->resource->id,
            'date' => $this->resource->date,
            'report' => $this->resource->report,
            'weight' => $this->resource->weight,
            'size' => $this->resource->size,
            'document_id' => $this->resource->document_id,
        ];
    }
}
