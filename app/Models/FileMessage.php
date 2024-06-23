<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class FileMessage extends Model
{
    use HasFactory;

    protected $table = 'file_messages';

    public function message():  MorphTo {
        return $this->morphTo();
    }

    public function file(): BelongsTo {
        return $this->belongsTo(File::class);
    }
}
