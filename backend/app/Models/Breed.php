<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     title="Breed",
 *     description="Breed model",
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         description="ID of the breed",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="name",
 *         type="string",
 *         description="Name of the breed",
 *         example="Labrador Retriever"
 *     ),
 *     @OA\Property(
 *         property="description",
 *         type="string",
 *         description="Description of the breed",
 *         example="A medium-large gun dog breed known for its friendly and outgoing nature"
 *     ),
 *     @OA\Property(
 *         property="specie_id",
 *         type="integer",
 *         description="ID of the species to which the breed belongs",
 *         example=1
 *     )
 * )
 */

class Breed extends Model
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

    public function specie(): BelongsTo
    {
        return $this->belongsTo(Specie::class);
    }
}
