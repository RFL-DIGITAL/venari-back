<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class City extends Model
{
    use HasFactory;

    public function schools(): HasMany {
        return $this->hasMany(School::class);
    }

    public function vacancies(): HasMany {
        return $this->hasMany(Vacancy::class);
    }
}