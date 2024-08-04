<?php

namespace App\Models;

use App\Contract\HasDocumentsInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="Animal",
 *     type="object",
 *     title="Animal",
 *     description="Animal model representing the detailed information of an animal in the system",
 *
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         format="int64",
 *         description="Unique identifier for the Animal",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="name",
 *         type="string",
 *         description="Name of the animal",
 *         example="Bella"
 *     ),
 *     @OA\Property(
 *         property="description",
 *         type="string",
 *         description="Description of the animal",
 *         example="A very playful young dog"
 *     ),
 *     @OA\Property(
 *         property="birth_date",
 *         type="string",
 *         format="date",
 *         description="Birth date of the animal",
 *         example="2017-04-21"
 *     ),
 *     @OA\Property(
 *         property="cats_friendly",
 *         type="boolean",
 *         description="Indicates if the animal is friendly towards cats",
 *         example=true
 *     ),
 *     @OA\Property(
 *         property="dogs_friendly",
 *         type="boolean",
 *         description="Indicates if the animal is friendly towards dogs",
 *         example=false
 *     ),
 *     @OA\Property(
 *         property="children_friendly",
 *         type="boolean",
 *         description="Indicates if the animal is friendly towards children",
 *         example=true
 *     ),
 *     @OA\Property(
 *         property="age",
 *         type="integer",
 *         format="int32",
 *         description="Age of the animal",
 *         example=3
 *     ),
 *     @OA\Property(
 *         property="behavioral_comment",
 *         type="string",
 *         description="Behavioral comments about the animal",
 *         example="Needs a lot of exercise"
 *     ),
 *     @OA\Property(
 *         property="sterilized",
 *         type="boolean",
 *         description="Indicates if the animal is sterilized",
 *         example=true
 *     ),
 *     @OA\Property(
 *         property="deceased",
 *         type="boolean",
 *         description="Indicates if the animal is deceased",
 *         example=false
 *     ),
 *      * @OA\Property(
 *     property="specie_id",
 *     type="integer",
 *     format="int64",
 *     description="Foreign key identifier for the species to which the animal belongs",
 *     example=1
 *      ),
 *     @OA\Property(
 *         property="breed_id",
 *         type="integer",
 *         format="int64",
 *         description="Foreign key identifier for the breed to which the animal belongs",
 *         example=2
 *     ),
 *     @OA\Property(
 *         property="gender_id",
 *         type="integer",
 *         format="int64",
 *         description="Foreign key identifier for the gender to which the animal belongs",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="color_id",
 *         type="integer",
 *         format="int64",
 *         description="Foreign key identifier for the color to which the animal belongs",
 *         example=3
 *     ),
 *     @OA\Property(
 *         property="coat_id",
 *         type="integer",
 *         format="int64",
 *         description="Foreign key identifier for the coat type of the animal",
 *         example=4
 *     ),
 *     @OA\Property(
 *         property="sizerange_id",
 *         type="integer",
 *         format="int64",
 *         description="Foreign key identifier for the size range to which the animal belongs",
 *         example=5
 *     ),
 *     @OA\Property(
 *         property="agerange_id",
 *         type="integer",
 *         format="int64",
 *         description="Foreign key identifier for the age range to which the animal belongs",
 *         example=6
 *     )
 * )
 */
class Animal extends Model implements HasDocumentsInterface
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'name', 'description', 'birth_date', 'cats_friendly', 'dogs_friendly',
        'children_friendly', 'age', 'behavioral_comment', 'sterilized', 'deceased',
        'specie_id', 'breed_id', 'gender_id', 'color_id', 'coat_id', 'sizerange_id', 'agerange_id',
    ];

    public function gender(): BelongsTo
    {
        return $this->belongsTo(Gender::class);
    }

    public function breed(): BelongsTo
    {
        return $this->belongsTo(Breed::class);
    }

    public function specie(): BelongsTo
    {
        return $this->belongsTo(Specie::class);
    }

    public function coat(): BelongsTo
    {
        return $this->belongsTo(Coat::class);
    }

    public function color(): BelongsTo
    {
        return $this->belongsTo(Color::class);
    }

    public function SizeRange(): BelongsTo
    {
        return $this->belongsTo(SizeRange::class, 'sizerange_id');
    }

    public function AgeRange(): BelongsTo
    {
        return $this->belongsTo(AgeRange::class, 'agerange_id');
    }

    public function vaccines(): BelongsToMany
    {
        return $this->belongsToMany(Vaccine::class, 'animal_vaccine');
    }

    public function healthcares(): HasMany
    {
        return $this->hasMany(Healthcare::class);
    }

    public function identification(): HasOne
    {
        return $this->hasOne(Identification::class);
    }

    public function users1(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'animal_user')
            ->withPivot('comment')
            ->withTimestamps();
    }

    public function documents(): BelongsToMany
    {
        return $this->belongsToMany(Document::class);
    }

    public function getDocuments(): \Illuminate\Database\Eloquent\Collection
    {
        return $this->belongsToMany(Document::class)->get();
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'animal_shelter_user')
            ->withPivot('user_id')
            ->withTimestamps();
    }

    public function shelters()
    {
        return $this->belongsToMany(Shelter::class, 'animal_shelter_user')
            ->withPivot('shelter_id')
            ->withTimestamps();
    }

    public function statuses(): BelongsToMany
    {
        return $this->belongsToMany(Status::class);
    }

    public function getSpecieNameAttribute()
    {
        return $this->specie ? $this->specie->name : null;
    }

    public function getGenderNameAttribute()
    {
        return $this->gender ? $this->gender->name : null;
    }

    public function getColorNameAttribute()
    {
        return $this->color ? $this->color->name : null;
    }

    public function getCoatNameAttribute()
    {
        return $this->coat ? $this->coat->name : null;
    }

    public function getSizerangeNameAttribute()
    {
        return $this->sizerange ? $this->sizerange->name : null;
    }

    public function getAgerangeNameAttribute()
    {
        return $this->agerange ? $this->agerange->name : null;
    }
}
