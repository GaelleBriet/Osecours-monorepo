<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Animal extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        "name",
        "description",
        "birth_date",
        "cats_friendly",
        "dogs_friendly",
        "children_friendly",
        "age",
        "behavioral_comment",
        "sterilized",
        "deceased"
    ];

    public function gender(): BelongsTo
    {
        return $this->belongsTo(Gender::class);
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

    public function size_range(): BelongsTo
    {
        return $this->belongsTo(Size_range::class);
    }

    public function age_range(): BelongsTo
    {
        return $this->belongsTo(Age_range::class);
    }

    public function vaccines(): HasMany
    {
        return $this->hasMany(Vaccine::class);
    }

    public function healthcares(): HasMany
    {
        return $this->hasMany(Healthcare::class);
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
}
