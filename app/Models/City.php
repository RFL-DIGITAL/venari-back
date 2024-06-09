<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class City extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'preview_id'];

    public function schools(): HasMany {
        return $this->hasMany(School::class);
    }

    public function vacancies(): HasMany {
        return $this->hasMany(Vacancy::class);
    }

    public function streets(): HasMany {
        return $this->hasMany(Street::class);
    }

    public function country(): BelongsTo {
        return $this->belongsTo(Country::class);
    }
}
