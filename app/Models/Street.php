<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Scout\Searchable;

class Street extends Model
{
    use HasFactory, Searchable;

    public function buildings(): HasMany {
        return $this->hasMany(Building::class);
    }

    public function city(): BelongsTo {
        return $this->belongsTo(City::class);
    }
}
