<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Traits\RoleAssociation;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable,HasApiTokens,RoleAssociation;

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

    public function animals(): BelongsToMany
    {
        return $this->belongsToMany(Animal::class, 'animal_user')
        ->withPivot('comment')
        ->withTimestamps();
    }
}
