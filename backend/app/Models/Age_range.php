<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     title="Age Range",
 *     description="Age Range model",
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         description="ID of the age range",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="name",
 *         type="string",
 *         description="Name of the age range",
 *         example="Adult"
 *     ),
 *     @OA\Property(
 *         property="description",
 *         type="string",
 *         description="Description of the age range",
 *         example="Between 3 to 7 years old"
 *     ),
 * )
 */

class Age_range extends Model
{
    use HasFactory;

    protected $table = "age_ranges";
    
    protected $fillable = [
        'name',
        'description',
    ];

    public function animals(): HasMany
    {
        return $this->hasMany(Animal::class);
    }
}
