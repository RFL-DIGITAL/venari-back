<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use phpseclib3\Math\BigInteger\Engines\PHP\Reductions\Classic;

class LanguageLevel extends Model
{
    use HasFactory;

    protected $fillable = [
        'level_id',
        'language_id',
    ];

    public function language(): BelongsTo {
        return $this->belongsTo(Language::class);
    }

    public function level(): BelongsTo {
        return $this->belongsTo(Level::class);
    }

    public function resumes(): BelongsToMany{
        return $this->belongsToMany(Resume::class, 'language_level_resumes');
    }
}
