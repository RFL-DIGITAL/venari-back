<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'from_id',
        'to_id',
        'body',
    ];

    public function owner(): BelongsTo {
        return $this->belongsTo(User::class, 'from_id', 'id');
    }

    public function destination(): BelongsTo {
        return $this->belongsTo(User::class, 'to_id', 'id');
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
        return $this->morphOne(LinkMessage::class, 'message');
    }
}
