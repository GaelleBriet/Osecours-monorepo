<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Specie extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
    ];

    public function animals(): HasMany
    {
        return $this->hasMany(Animal::class);
    }

    public function breeds(): HasMany
    {
        return $this->hasMany(Breed::class);
    }

    public function colors(): BelongsToMany
    {
        return $this->belongsToMany(Color::class);
    }

    public function coats(): BelongsToMany
    {
        return $this->belongsToMany(Coat::class);
    }

    public function vaccines(): BelongsToMany
    {
        return $this->belongsToMany(Vaccine::class);
    }
}
