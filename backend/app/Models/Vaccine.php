<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     title="Vaccine",
 *     description="Vaccine model",
 *
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         description="ID of the vaccine",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="name",
 *         type="string",
 *         description="Name of the vaccine",
 *         example="Rabies"
 *     ),
 *     @OA\Property(
 *         property="description",
 *         type="string",
 *         description="Description of the vaccine",
 *         example="Prevents rabies infection in animals"
 *     ),
 *     @OA\Property(
 *         property="created_at",
 *         type="string",
 *         format="date-time",
 *         description="Date and time when the vaccine was created"
 *     ),
 *     @OA\Property(
 *         property="updated_at",
 *         type="string",
 *         format="date-time",
 *         description="Date and time when the vaccine was last updated"
 *     ),
 * )
 */
class Vaccine extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
    ];

    public function animals(): BelongsToMany
    {
        return $this->belongsToMany(Animal::class, 'animal_vaccine');
    }

    public function species(): BelongsToMany
    {
        return $this->belongsToMany(Specie::class);
    }
}
