<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Image extends Model
{
    use HasFactory;

    protected $fillable = [
        'image',
        'description'
    ];

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function posts(): BelongsToMany{
        return $this->belongsToMany(Post::class, 'image_post');
    }

    public function chats(): HasMany{
        return $this->hasMany(Chat::class);
    }

    public function companies(): HasMany
    {
        return $this->hasMany(Image::class);
    }

    public function vacancies(): HasMany
    {
        return $this->hasMany(Image::class);
    }

    public function imageBlocks(): BelongsToMany {
        return $this->belongsToMany(ImageBlock::class, 'image_block_images');
    }
}
