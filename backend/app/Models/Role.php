<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     title="Role",
 *     description="Role model",
 *
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         description="ID of the role",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="name",
 *         type="string",
 *         description="Name of the role",
 *         example="admin"
 *     ),
 *     @OA\Property(
 *         property="created_at",
 *         type="string",
 *         format="date-time",
 *         description="Date and time when the role was created"
 *     ),
 *     @OA\Property(
 *         property="updated_at",
 *         type="string",
 *         format="date-time",
 *         description="Date and time when the role was last updated"
 *     ),
 * )
 */
class Role extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'name',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'association_role_user')
            ->withPivot('association_id')
            ->withTimestamps();
    }

    public function associations()
    {
        return $this->belongsToMany(Association::class, 'association_role_user')
            ->withPivot('user_id')
            ->withTimestamps();
    }
}
