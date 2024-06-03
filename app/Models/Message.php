<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Message extends Model
{
    use HasFactory;

    public function owner(): BelongsTo {
        return $this->belongsTo(User::class, 'from_id', 'id');
    }

    public function destination(): BelongsTo {
        return $this->belongsTo(User::class, 'to_id', 'id');
    }
}
