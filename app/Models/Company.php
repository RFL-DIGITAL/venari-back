<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
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

    public function building (): BelongsTo
    {
        return $this->belongsTo(Building::class);
    }

    public function preview(): BelongsTo
    {
        return $this->belongsTo(Preview::class);
    }

    public function image(): BelongsTo
    {
        return $this->belongsTo(Image::class);
    }

    public function users(): HasMany {
        return $this->hasMany(User::class);
    }

    public function companyChats(): HasMany {
        return $this->hasMany(CompanyChat::class);
    }
}
