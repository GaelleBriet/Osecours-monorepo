<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Traits\RoleAssociation;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     title="User",
 *     description="User model",
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         description="ID of the user",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="first_name",
 *         type="string",
 *         description="First name of the user",
 *         example="John"
 *     ),
 *     @OA\Property(
 *         property="last_name",
 *         type="string",
 *         description="Last name of the user",
 *         example="Doe"
 *     ),
 *     @OA\Property(
 *         property="phone",
 *         type="string",
 *         description="Phone number of the user",
 *         example="123456789"
 *     ),
 *     @OA\Property(
 *         property="existing_cat_count",
 *         type="integer",
 *         description="Number of existing cats owned by the user",
 *         example=2
 *     ),
 *     @OA\Property(
 *         property="existing_children_count",
 *         type="integer",
 *         description="Number of existing children of the user",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="existing_dog_count",
 *         type="integer",
 *         description="Number of existing dogs owned by the user",
 *         example=0
 *     ),
 *     @OA\Property(
 *         property="email",
 *         type="string",
 *         description="Email address of the user",
 *         example="john@example.com"
 *     ),
 *     @OA\Property(
 *         property="created_at",
 *         type="string",
 *         format="date-time",
 *         description="Date and time when the user was created"
 *     ),
 *     @OA\Property(
 *         property="updated_at",
 *         type="string",
 *         format="date-time",
 *         description="Date and time when the user was last updated"
 *     ),
 * )
 */

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens, RoleAssociation, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'phone',
        'existing_cat_count',
        'existing_children_count',
        'existing_dog_count',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function person() {
        return $this->morphOne(Person::class, 'personable');
    }

    public function associations()
    {
        return $this->belongsToMany(Association::class, 'association_role_user')
                    ->withPivot('role_id')
                    ->withTimestamps();
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'association_role_user')
                    ->withPivot('association_id')
                    ->withTimestamps();
    }

    public function animals1(): BelongsToMany
    {
        return $this->belongsToMany(Animal::class, 'animal_user')
        ->withPivot('comment')
        ->withTimestamps();
    }

    public function animals()
    {
        return $this->belongsToMany(Animal::class, 'animal_shelter_user')
            ->withPivot('animal_id')
            ->withTimestamps();
    }

    public function shelters()
    {
        return $this->belongsToMany(Shelter::class, 'animal_shelter_user')
            ->withPivot('shelter_id')
            ->withTimestamps();
    }

    public function association_role_user()
    {
        return $this->belongsToMany(Association::class, 'association_role_user')
                    ->withPivot('role_id')
                    ->withTimestamps();
    }
}
