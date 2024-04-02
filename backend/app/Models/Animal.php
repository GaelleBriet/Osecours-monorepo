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
}
