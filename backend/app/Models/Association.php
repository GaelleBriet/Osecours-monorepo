<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     title="Association",
 *     description="Association model",
 *
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         description="ID of the association",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="name",
 *         type="string",
 *         description="Name of the association",
 *         example="Animal Rescue Association"
 *     ),
 *     @OA\Property(
 *         property="description",
 *         type="string",
 *         description="Description of the association",
 *         example="A non-profit organization dedicated to rescuing animals"
 *     ),
 *     @OA\Property(
 *         property="siret",
 *         type="string",
 *         minLength=14,
 *         maxLength=14,
 *         description="SIRET number of the association",
 *         example="12345678901234"
 *     ),
 *     @OA\Property(
 *         property="rib",
 *         type="string",
 *         maxLength=34,
 *         description="RIB (Relevé d'Identité Bancaire) of the association",
 *         example="FRXX XXXX XXXX XXXX XXXX XXXX XXX"
 *     )
 * )
 */
class Association extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'siret',
        'rib',
    ];

    public function person()
    {
        return $this->morphOne(Person::class, 'personable');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'association_role_user')
            ->withPivot('role_id')
            ->withTimestamps();
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'association_role_user')
            ->withPivot('user_id')
            ->withTimestamps();
    }

    public function shelters()
    {
        return $this->belongsToMany(Shelter::class, 'association_shelter')
            ->withPivot('begin_date')
            ->withPivot('end_date')
            ->withTimestamps();
    }
}
