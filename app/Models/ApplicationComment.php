<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ApplicationComment extends Model
{
    use HasFactory;

    protected $fillable =
        [
            'text'
        ];

    public function application(): BelongsTo {
        return $this->belongsTo(Application::class);
    }

    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }
}
