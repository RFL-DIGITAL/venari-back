<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Scout\Searchable;

class Language extends Model
{
    use HasFactory, Searchable;

    protected $fillable = [
        'name',
    ];

    public function languageLevels(): HasMany {
        return $this->hasMany(LanguageLevel::class);
    }
}
