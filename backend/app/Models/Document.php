<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

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

    public function healthcare(): HasOne
    {
        return $this->hasOne(Healthcare::class);
    }

    public function animals(): BelongsToMany
    {
        return $this->belongsToMany(Animal::class);
    }
}
