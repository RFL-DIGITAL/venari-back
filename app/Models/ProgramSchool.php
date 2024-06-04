<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Связывающая сущность, реализующая многие-ко-многим между Program и School
 */
class ProgramSchool extends Model
{
    use HasFactory;

    protected $table = 'program_schools';

    public function program(): BelongsTo
    {
        return $this->belongsTo(Program::class);
    }

    public function school(): BelongsTo
    {
        return $this->belongsTo(School::class);
    }

    public function resumeProgramSchools(): HasMany {
        return $this->hasMany(ResumeProgramSchool::class);
    }
}