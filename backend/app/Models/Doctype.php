<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     title="Doctype",
 *     description="Document Type model",
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         description="ID of the document type",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="name",
 *         type="string",
 *         description="Name of the document type",
 *         example="Passport"
 *     ),
 *     @OA\Property(
 *         property="description",
 *         type="string",
 *         description="Description of the document type",
 *         example="A passport document"
 *     )
 * )
 */

class Doctype extends Model
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
