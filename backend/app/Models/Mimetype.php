<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     title="Mimetype",
 *     description="Mimetype model",
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         description="ID of the mimetype",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="name",
 *         type="string",
 *         description="Name of the mimetype",
 *         example="application/pdf"
 *     )
 * )
 */

class Mimetype extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function animals(): HasMany
    {
        return $this->hasMany(Animal::class);
    }
}
