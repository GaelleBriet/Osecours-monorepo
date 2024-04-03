<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Animal extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        "id",
        "name",
        "description",
        "birth_date",
        "cats_friendly",
        "dogs_friendly",
        "children_friendly",
        "age",
        "behavioral_comment",
        "sterilized",
        "deceased"
    ];

    public function gender(): HasOne
    {
        return $this->hasOne(Gender::class);
    }

    public function specie(): HasOne
    {
        return $this->hasOne(Specie::class);
    }

    public function coat(): HasOne
    {
        return $this->hasOne(Coat::class);
    }

    public function color(): HasOne
    {
        return $this->hasOne(Color::class);
    }

    public function size_range(): HasOne
    {
        return $this->hasOne(Size_range::class);
    }

    public function age_range(): HasOne
    {
        return $this->hasOne(Age_range::class);
    }
}
