<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Laravel\Scout\Searchable;

class Approve extends Model
{
    use HasFactory, Searchable;

    protected $fillable =
        [
            'name',
            'surname',
            'status',
            'application_id',
            'text'
        ];

    public function application(): BelongsTo {
        return $this->belongsTo(Application::class);
    }
}
