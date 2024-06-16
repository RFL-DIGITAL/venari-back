<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Scout\Searchable;

/**
 * Связывающая сущность, реализующая многие-ко-многим между Program и School
 */
class ProgramSchool extends Model
{
    use HasFactory, Searchable;

    protected $fillable = [
        'program_id',
        'school_id'
    ];

    public function program(): BelongsTo
    {
        return $this->belongsTo(Program::class);
    }

    public function school(): BelongsTo
    {
        return $this->belongsTo(School::class);
    }

    public function resumeProgramSchools(): HasMany {
        return $this->hasMany(ResumeProgramSchool::class, 'programSchool_id', 'id');
    }
}
