<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Scout\Searchable;

class Chat extends Model
{
    use HasFactory;

    protected $appends = [
        'member_count',
        'is_joined'
    ];


    /**
     * @return int - количество комментариев к этому посту
     */
    public function getMemberCountAttribute(): int
    {
        return $this->users()->count();
    }

    public function getisJoinedAttribute(): bool
    {
        return $this->users()->get()->pluck('id')->contains(auth()->id());
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    public function messages(): HasMany
    {
        return $this->hasMany(ChatMessage::class);
    }

    public function image(): BelongsTo
    {
        return $this->belongsTo(Image::class);
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'chat_tags');
    }
}
