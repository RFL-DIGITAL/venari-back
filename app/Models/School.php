<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class School extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];

    public function programs(): BelongsToMany {
        return $this->belongsToMany(Program::class);
    }

    public function programSchools(): HasMany {
        return $this->hasMany(ProgramSchool::class);
    }
}
