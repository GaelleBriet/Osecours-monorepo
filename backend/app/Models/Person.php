<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     title="Person",
 *     description="Person model",
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         description="ID of the person",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="created_at",
 *         type="string",
 *         format="date-time",
 *         description="Date and time when the person was created"
 *     ),
 *     @OA\Property(
 *         property="updated_at",
 *         type="string",
 *         format="date-time",
 *         description="Date and time when the person was last updated"
 *     ),
 *     @OA\Property(
 *         property="personable_type",
 *         type="string",
 *         description="Type of the associated entity (morphed)"
 *     ),
 *     @OA\Property(
 *         property="personable_id",
 *         type="integer",
 *         description="ID of the associated entity (morphed)"
 *     )
 * )
 */

class Person extends Model
{
    use HasFactory;

    protected $table = 'persons';

    public function personable() {
        return $this->morphTo();
    }
    
    public function addresses() {
        return $this->belongsToMany(Address::class, 'address_person');
    }
}
