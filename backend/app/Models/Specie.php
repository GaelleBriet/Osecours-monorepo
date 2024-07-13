<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     title="Specie",
 *     description="Specie model",
 *
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         description="ID of the specie",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="name",
 *         type="string",
 *         description="Name of the specie",
 *         example="Cat"
 *     ),
 *     @OA\Property(
 *         property="description",
 *         type="string",
 *         description="Description of the specie",
 *         example="Domestic cat"
 *     ),
 *     @OA\Property(
 *         property="created_at",
 *         type="string",
 *         format="date-time",
 *         description="Date and time when the specie was created"
 *     ),
 *     @OA\Property(
 *         property="updated_at",
 *         type="string",
 *         format="date-time",
 *         description="Date and time when the specie was last updated"
 *     ),
 * )
 */
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
