<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Scout\Searchable;

class Employment extends Model
{
    use HasFactory, Searchable;

    protected $fillable = [
        'name'
    ];

    public function vacancies(): HasMany
    {
        return $this->hasMany(Vacancy::class);
    }

    public function resumes(): hasMany {
        return $this->hasMany(Resume::class);
    }
}
