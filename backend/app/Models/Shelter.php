<?php

namespace App\Models;

use App\Contract\HasDocumentsInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     title="Shelter",
 *     description="Shelter model",
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         description="ID of the shelter",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="name",
 *         type="string",
 *         description="Name of the shelter",
 *         example="Animal Shelter"
 *     ),
 *     @OA\Property(
 *         property="description",
 *         type="string",
 *         description="Description of the shelter",
 *         example="A shelter for homeless animals"
 *     ),
 *     @OA\Property(
 *         property="phone",
 *         type="string",
 *         description="Phone number of the shelter",
 *         example="123-456-7890"
 *     ),
 *     @OA\Property(
 *         property="email",
 *         type="string",
 *         description="Email address of the shelter",
 *         example="info@example.com"
 *     ),
 *     @OA\Property(
 *         property="siret",
 *         type="string",
 *         minLength=14,
 *         maxLength=14,
 *         description="SIRET number of the shelter",
 *         example="12345678901234"
 *     ),
 *     @OA\Property(
 *         property="created_at",
 *         type="string",
 *         format="date-time",
 *         description="Date and time when the shelter was created"
 *     ),
 *     @OA\Property(
 *         property="updated_at",
 *         type="string",
 *         format="date-time",
 *         description="Date and time when the shelter was last updated"
 *     ),
 * )
 */

class Shelter extends Model implements HasDocumentsInterface
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'phone',
        'email',
        'siret',
    ];

    public function person() {
        return $this->morphOne(Person::class, 'personable');
    }

    public function associations()
    {
        return $this->belongsToMany(Association::class, 'association_shelter')
            ->withPivot('begin_date')
            ->withPivot('end_date')
            ->withTimestamps();
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'animal_shelter_user')
            ->withPivot('user_id')
            ->withTimestamps();
    }

    public function animals()
    {
        return $this->belongsToMany(Animal::class, 'animal_shelter_user')
            ->withPivot('animal_id')
            ->withTimestamps();
    }

    public function documents(): BelongsToMany
    {
        return $this->belongsToMany(Document::class);
    }

    public function getDocuments()
    {
        return $this->belongsToMany(Document::class)->get();
    }
}
