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

    public function roles(): BelongsToMany{
        return $this->belongsToMany(Role::class);
    }

    public function users(): BelongsToMany{
        return $this->belongsToMany(User::class);
    }
}
