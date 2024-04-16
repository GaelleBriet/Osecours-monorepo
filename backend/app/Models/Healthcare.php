<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Healthcare extends Model
{
    use HasFactory;

    protected $fillable = [
        "date",
        "report",
        "weight",
        "size",
        "animal_id",
        "document_id"
    ];

    public function animal(): HasOne
    {
        return $this->hasOne(Animal::class);
    }

    public function document(): BelongsTo
    {
        return $this->belongsTo(Document::class);
    }
}
