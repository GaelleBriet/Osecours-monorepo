<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Document extends Model
{
    use HasFactory;

    protected $fillable = [
        'filename',
        'description',
        'size',
        'url',
        'date',
    ];

    public function doctype(): BelongsTo
    {
        return $this->belongsTo(Doctype::class);
    }

    public function mimetype(): BelongsTo
    {
        return $this->belongsTo(Mimetype::class);
    }

    public function healthcares(): HasMany
    {
        return $this->hasMany(Healthcare::class);
    }
}
