<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     title="Gender",
 *     description="Gender model",
 *
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         description="ID of the gender",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="name",
 *         type="string",
 *         description="Name of the gender",
 *         example="Male"
 *     ),
 *     @OA\Property(
 *         property="description",
 *         type="string",
 *         description="Description of the gender",
 *         example="Male gender"
 *     )
 * )
 */
class Gender extends Model
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
}
