<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $fillable = [
        'street1',
        'street2',
    ];

    public function cities() {
        return $this->belongsToMany(City::class);
    }
}
