<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class HealthcareResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'date' => $this->date,
            'report' => $this->report,
            'weight' => $this->weight,
            'size' => $this->size,
            'document_id' => $this->document_id,
        ];
    }
}
