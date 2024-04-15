<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shelter extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'phone',
        'email',
        'siret',
    ];

    public function person() {
        return $this->morphOne(Person::class, 'personable');
    }

    public function associations()
    {
        return $this->belongsToMany(Association::class, 'association_shelter')
            ->withPivot('association_id')
            ->withTimestamps();
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'animal_shelter_user')
            ->withPivot('user_id')
            ->withTimestamps();
    }

    public function animals()
    {
        return $this->belongsToMany(Animal::class, 'animal_shelter_user')
            ->withPivot('animal_id')
            ->withTimestamps();
    }
}
