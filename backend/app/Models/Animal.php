<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Animal extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
    */
    $fillable = [
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
    ]
}
