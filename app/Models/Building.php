<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Scout\Searchable;

class Building extends Model
{
    use HasFactory, Searchable;

    public function street(): BelongsTo {
        return $this->belongsTo(Street::class);
    }

    public function companies (): HasMany
    {
        return $this->HasMany(Company::class);
    }
}
