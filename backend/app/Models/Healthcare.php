<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Healthcare extends Model
{
    use HasFactory;

    protected $fillable = [
        "date",
        "report",
        "weight",
        "size",
        "type"
    ];

    public function animal(): BelongsTo
    {
        return $this->belongsTo(Animal::class);
    }

    public function document(): HasOne
    {
        return $this->hasOne(Document::class);
    }
}
