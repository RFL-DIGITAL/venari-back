<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Scout\Searchable;

class Format extends Model
{
    use HasFactory, Searchable;

    protected $fillable =
        [
            'name'
        ];

    public function vacancies(): hasMany {
        return $this->hasMany(Vacancy::class);
    }

    public function resumes(): hasMany {
        return $this->hasMany(Resume::class);
    }
}
