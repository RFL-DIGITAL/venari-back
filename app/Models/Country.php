<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Scout\Searchable;

class Country extends Model
{
    use HasFactory, Searchable;

    public function cities():HasMany {
        return $this->hasMany(City::class);
    }
}
