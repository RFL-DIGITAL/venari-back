<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Company extends Model
{
    use HasFactory;

    public function vacancies(): HasMany
    {
        return $this->hasMany(Vacancy::class);
    }

    public function hrs(): HasMany
    {
        return $this->hasMany(HR::class);
    }

    public function userPositions(): HasMany {
        return $this->hasMany(UserPosition::class);
    }
}
