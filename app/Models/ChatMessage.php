<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class ChatMessage extends Model
{
    use HasFactory;

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function chat(): BelongsTo
    {
        return $this->belongsTo(Chat::class);
    }

    public function fileMessage(): MorphOne
    {
        return $this->morphOne(FileMessage::class, 'message');
    }

    public function imageMessage(): MorphOne
    {
        return $this->morphOne(ImageMessage::class, 'message');
    }

    public function linkMessage(): MorphOne
    {
        return $this->morphOne(ImageMessage::class, 'message');
    }
}
