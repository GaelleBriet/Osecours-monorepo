<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     title="Status",
 *     description="Status model",
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         description="ID of the status",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="name",
 *         type="string",
 *         description="Name of the status",
 *         example="Adopted"
 *     ),
 *     @OA\Property(
 *         property="description",
 *         type="string",
 *         description="Description of the status",
 *         example="The animal has been adopted"
 *     ),
 *     @OA\Property(
 *         property="created_at",
 *         type="string",
 *         format="date-time",
 *         description="Date and time when the status was created"
 *     ),
 *     @OA\Property(
 *         property="updated_at",
 *         type="string",
 *         format="date-time",
 *         description="Date and time when the status was last updated"
 *     ),
 * )
 */

class Status extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
    ];

    public function animals(): BelongsToMany    {
        return $this->belongsToMany(Animal::class);
    }
}
