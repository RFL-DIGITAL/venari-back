<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class ApplicationTag extends Model
{
    use HasFactory;

    protected $fillable =
        [
            'name'
        ];

    public function applications(): BelongsToMany {
        return $this->belongsToMany(Application::class, 'application_application_tags');
    }
}
