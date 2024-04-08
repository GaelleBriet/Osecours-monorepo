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
}
