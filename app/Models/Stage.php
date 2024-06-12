<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Stage extends Model
{
    use HasFactory;

    protected $fillable =
        [
            'name'
        ];

    public function applications(): hasMany {
        return $this->hasMany(Application::class);
    }

    public function stageType(): BelongsTo {
        return $this->belongsTo(StageType::class, 'stageType_id', 'id');
    }
}
