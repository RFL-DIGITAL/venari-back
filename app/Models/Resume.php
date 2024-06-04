<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Resume extends Model
{
    use HasFactory;

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function userPositions(): BelongsToMany
    {
        return $this->belongsToMany(UserPosition::class, 'user_position_resume');
    }

    public function skills(): BelongsToMany
    {
        return $this->belongsToMany(Skill::class, 'resume_skills');
    }

    public function resumeProgramSchools(): HasMany
    {
        return $this->hasMany(ResumeProgramSchool::class);
    }
}
