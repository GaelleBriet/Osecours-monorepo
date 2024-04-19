<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     title="Color",
 *     description="Color model",
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         description="ID of the color",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="name",
 *         type="string",
 *         description="Name of the color",
 *         example="Red"
 *     ),
 *     @OA\Property(
 *         property="description",
 *         type="string",
 *         description="Description of the color",
 *         example="A vibrant red color"
 *     ),
 *     @OA\Property(
 *         property="specie_id",
 *         type="integer",
 *         description="ID of the species associated with this color",
 *         example=1
 *     )
 * )
 */

class Color extends Model
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
