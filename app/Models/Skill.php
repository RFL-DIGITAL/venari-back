<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;


class Skill extends Model
{
    use HasFactory;

    public function resumes(): BelongsToMany {
        return $this->belongsToMany(Resume::class, 'resume_skills');
    }

    public function vacancies(): BelongsToMany {
        return $this->belongsToMany(Vacancy::class, 'skill_vacancies');
    }
}
