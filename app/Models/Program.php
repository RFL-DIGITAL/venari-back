<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Program extends Model
{
    use HasFactory;

    public function schools(): BelongsToMany {
        return $this->belongsToMany(School::class, 'program_schools');
    }

    public function programSchools(): HasMany {
        return $this->hasMany(ProgramSchool::class);
    }
}
