<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class ImageMessage extends Model
{
    use HasFactory;

    protected $table = 'image_messages';

    public function message():  MorphTo {
        return $this->morphTo();
    }

    public function image(): BelongsTo {
        return $this->belongsTo(Image::class);
    }
}
