<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     title="City",
 *     description="City model",
 *
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         description="ID of the city",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="name",
 *         type="string",
 *         description="Name of the city",
 *         example="New York"
 *     ),
 *     @OA\Property(
 *         property="zipcode",
 *         type="string",
 *         description="Zip code of the city",
 *         example="10001"
 *     ),
 * )
 */
class City extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'zipcode',
    ];

    public function addresses()
    {
        return $this->hasMany(Address::class);
    }
}
