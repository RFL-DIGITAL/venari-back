<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Scout\Searchable;

class ProgramType extends Model
{
    use HasFactory, Searchable;

    protected $fillable = [
        'name'
    ];

    function programs(): HasMany{
        return $this->hasMany(Program::class);
    }
}
