<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Связывающая сущность, реализующая многие-ко-многим между Resume и ProgramSchool
 */
class ResumeProgramSchool extends Model
{
    use HasFactory;

    protected $table = 'program_school_resumes';

    protected $fillable = [
        'programSchool_id',
        'resume_id',
        'start_date',
        'end_date',
    ];

    public function resume(): BelongsTo
    {
        return $this->belongsTo(Resume::class);
    }

    public function programSchool(): BelongsTo {
        return $this->belongsTo(ProgramSchool::class, 'programSchool_id', 'id');
    }
}
