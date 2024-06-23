<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class ImageBlock extends Model
{
    use HasFactory;

    public function part(): MorphOne
    {
        return $this->morphOne(Part::class, 'content');
    }

    public function images(): BelongsToMany {
        return $this->belongsToMany(Image::class, 'image_block_images');
    }
}
