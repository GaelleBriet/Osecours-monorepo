<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     title="Address",
 *     description="Address model",
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         description="ID of the address",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="street1",
 *         type="string",
 *         description="First line of the street address",
 *         example="123 Main St"
 *     ),
 *     @OA\Property(
 *         property="street2",
 *         type="string",
 *         description="Second line of the street address",
 *         example="Apt 101"
 *     ),
 *     @OA\Property(
 *         property="city_id",
 *         type="integer",
  *         description="ID of the city",
 *         example=1
 *     ),
 * )
 */

class Address extends Model
{
    use HasFactory;

    protected $fillable = [
        'street1',
        'street2',
    ];

    public function cities() {
        return $this->belongsTo(City::class);
    }
}
