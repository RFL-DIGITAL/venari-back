<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Scout\Searchable;

class Experience extends Model
{
    use HasFactory, Searchable;

    protected $fillable = [
        'name'
    ];

    public function vacancies(): HasMany
    {
        return $this->hasMany(Vacancy::class);
    }

    public function resumes(): HasMany
    {
        return $this->hasMany(Resume::class);
    }
}
