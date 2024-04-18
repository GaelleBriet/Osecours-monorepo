<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Association extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'siret',
        'rib'
    ];

    public function person()
    {
        return $this->morphOne(Person::class, 'personable');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'association_role_user')
            ->withPivot('role_id')
            ->withTimestamps();
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'association_role_user')
            ->withPivot('user_id')
            ->withTimestamps();
    }

    public function shelters()
    {
        return $this->belongsToMany(Shelter::class, 'association_shelter')
            ->withPivot('begin_date')
            ->withPivot('end_date')
            ->withTimestamps();
    }
}
