<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Calendar extends Model
{
    use HasFactory;

    public function position(): BelongsTo
    {
        return $this->belongsTo(HR::class);
    }

    public function events(): HasMany
    {
        return $this->HasMany(Event::class);
    }
}
