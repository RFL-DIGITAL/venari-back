<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class File extends Model
{
    use HasFactory;

    protected $fillable = [
        'file',
        'mime'
    ];

    public function fileMessages(): HasMany
    {
        return $this->hasMany(FileMessage::class);
    }
}
