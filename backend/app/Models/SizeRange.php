<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     title="SizeRange",
 *     description="SizeRange model",
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         description="ID of the size range",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="name",
 *         type="string",
 *         description="Name of the size range",
 *         example="Small"
 *     ),
 *     @OA\Property(
 *         property="description",
 *         type="string",
 *         description="Description of the size range",
 *         example="Small-sized animals"
 *     ),
 *     @OA\Property(
 *         property="created_at",
 *         type="string",
 *         format="date-time",
 *         description="Date and time when the size range was created"
 *     ),
 *     @OA\Property(
 *         property="updated_at",
 *         type="string",
 *         format="date-time",
 *         description="Date and time when the size range was last updated"
 *     ),
 * )
 */

class SizeRange extends Model
{
    use HasFactory;

    protected $table = "SizeRanges";

    protected $fillable = [
        'name',
        'description',
    ];

    public function animals(): HasMany
    {
        return $this->hasMany(Animal::class);
    }
}
