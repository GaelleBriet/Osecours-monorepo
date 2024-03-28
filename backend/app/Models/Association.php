<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Association extends Model
{
    use HasFactory;

    protected $fillable = [
        "name",
        "siret",
        "rib"
    ];

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
}
