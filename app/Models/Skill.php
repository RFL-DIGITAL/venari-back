<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Laravel\Scout\Searchable;


class Skill extends Model
{
    use HasFactory, Searchable;

    protected $fillable = [
        'name'
    ];

    public function resumes(): BelongsToMany {
        return $this->belongsToMany(Resume::class, 'resume_skills');
    }

    public function vacancies(): BelongsToMany {
        return $this->belongsToMany(Vacancy::class, 'skill_vacancies');
    }
}
