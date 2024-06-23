<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Part extends Model
{
    use HasFactory;

    public function post(): BelongsTo {
        return $this->belongsTo(Post::class);
    }

    public function content(): MorphTo
    {
        return $this->morphTo();
    }

}
