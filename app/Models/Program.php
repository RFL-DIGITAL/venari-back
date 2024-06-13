<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Program extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'program_type_id'
    ];

    public function programType(): BelongsTo
    {
        return $this->belongsTo(ProgramType::class);
    }

    public function schools(): BelongsToMany {
        return $this->belongsToMany(School::class, 'program_schools');
    }

    public function programSchools(): HasMany {
        return $this->hasMany(ProgramSchool::class);
    }
}
