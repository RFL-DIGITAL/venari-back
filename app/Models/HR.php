<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class HR extends Model
{
    use HasFactory;

    protected $table = 'hrs';

    public function user(): MorphOne
    {
        return $this->morphOne(User::class, 'hrable');
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }
}
