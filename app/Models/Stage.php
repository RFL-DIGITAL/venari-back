<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Scout\Searchable;

class Stage extends Model
{
    use HasFactory, Searchable;

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

    public function company(): BelongsTo {
        return $this->belongsTo(Company::class);
    }
}
