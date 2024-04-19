<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     title="Identification",
 *     description="Identification model",
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         description="ID of the identification record",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="date",
 *         type="string",
 *         format="date",
 *         description="Date of the identification",
 *         example="2022-04-16"
 *     ),
 *     @OA\Property(
 *         property="type",
 *         type="string",
 *         enum={"Chip", "Tatoo"},
 *         description="Type of identification (Chip or Tatoo)",
 *         example="Chip"
 *     ),
 *     @OA\Property(
 *         property="number",
 *         type="string",
 *         minLength=6,
 *         maxLength=15,
 *         description="Identification number",
 *         example="123456789"
 *     ),
 *     @OA\Property(
 *         property="animal_id",
 *         type="integer",
 *         description="ID of the associated animal",
 *         example=1
 *     )
 * )
 */

class Identification extends Model
{
    use HasFactory;

    protected $fillable = [
        "date",
        "type",
        "number",
        "animal_id"
    ];

    public function animal(): BelongsTo
    {
        return $this->belongsTo(Animal::class);
    }
}
