<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     title="Coat",
 *     description="Coat model",
 *
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         description="ID of the coat",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="name",
 *         type="string",
 *         description="Name of the coat",
 *         example="Short"
 *     ),
 *     @OA\Property(
 *         property="description",
 *         type="string",
 *         description="Description of the coat",
 *         example="A short-haired coat"
 *     )
 * )
 */
class Coat extends Model
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

    public function species(): BelongsToMany
    {
        return $this->belongsToMany(Specie::class);
    }
}
