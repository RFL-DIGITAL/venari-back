<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Laravel\Scout\Searchable;

class History extends Model
{
    use HasFactory, Searchable;

    protected $fillable = [
        'text',
        'application_id'
    ];

    public function application(): BelongsTo
    {
        return $this->belongsTo(Application::class);
    }
}
