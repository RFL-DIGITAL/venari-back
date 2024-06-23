<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Laravel\Scout\Searchable;

class Tag extends Model
{
    use HasFactory, Searchable;

    public function chats(): BelongsToMany {
        return $this->belongsToMany(Chat::class, 'chat_tags');
    }
}
