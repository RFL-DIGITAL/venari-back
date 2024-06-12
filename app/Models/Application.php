<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Application extends Model
{
    use HasFactory;

    public function comments(): hasMany {
        return $this->hasMany(ApplicationComment::class);
    }

    public function approves(): hasMany {
        return $this->hasMany(Approve::class);
    }

    public function tags(): BelongsToMany {
        return $this->belongsToMany(Tag::class, 'application_application_tags');
    }

    public function stage(): BelongsTo {
        return $this->belongsTo(Stage::class);
    }
}
