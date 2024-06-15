<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Event extends Model
{
    protected $fillable = [
        'title',
        'datetime_start',
        'datetime_end',
        'calendar_id',
    ];

    use HasFactory;

    public function calendar(): BelongsTo
    {
        return $this->belongsTo(Calendar::class);
    }
}
