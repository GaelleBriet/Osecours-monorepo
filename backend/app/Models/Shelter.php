<?php

namespace App\Models;

use App\Contract\HasDocumentsInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

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
